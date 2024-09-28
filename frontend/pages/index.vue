<template>
  <div class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center">
      <div></div>
      <h1 class="text-3xl font-bold text-center text-gray-900 mb-8">
        Agendar Cita con Doctor
      </h1>
      <NuxtLink
        to="/create-doctor"
        class="px-3 py-1 border border-green-200 mb-8 bg-white rounded hover:bg-green-300"
        >Registrar Doctor</NuxtLink
      >
    </div>
    <div class="grid grid-cols-12">
      <div
        class="flex justify-center mb-4 flex-col items-center gap-2 col-span-4"
      >
        <h2 class="text-lg font-bold">Buscar por rango de fecha</h2>

        <VDatePicker v-model="date" mode="date" :min-date="today" />
        <button
          @click="searchAvalaibles"
          role="button"
          :disabled="pending"
          class="px-8 py-4 bg-blue-500 rounded text-white hover:bg-blue-800"
        >
          Buscar disponiblidad
        </button>
      </div>
      <div
        class="flex justify-center mb-4 flex-col items-center gap-2 col-span-4"
      >
        <h2 class="text-lg font-bold">Generar Reporte por rango de fecha</h2>
        <VDatePicker v-model.range="date3" mode="date" :min-date="today" />
        <button
          @click="generateReport"
          role="button"
          :disabled="pending"
          class="px-8 py-4 bg-blue-500 rounded text-white hover:bg-blue-800"
        >
          Generar reporte
        </button>
      </div>
      <div
        class="flex justify-center mb-4 flex-col items-center gap-2 col-span-4"
      >
        <h2 class="text-lg font-bold">Buscar por fecha y hora</h2>
        <VDatePicker
          v-model="date2"
          mode="dateTime"
          :min-date="today"
          is24hr
          :rules="rules"
        />
        <button
          @click="searchAvalaiblesOnTime"
          role="button"
          :disabled="pending"
          class="px-8 py-4 bg-blue-500 rounded text-white hover:bg-blue-800"
        >
          Buscar disponiblidad
        </button>
      </div>
    </div>
    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
      v-if="pending === false"
    >
      <div
        v-for="doctor in doctors"
        :key="doctor.id"
        class="bg-white rounded-lg shadow-md overflow-hidden"
      >
        <div class="p-6">
          <div class="flex items-center mb-4 justify-between">
            <div>
              <h2 class="text-xl font-semibold text-gray-900">
                {{ doctor.fullname }}
              </h2>
              <p class="text-gray-600">{{ doctor.speciality }}</p>
            </div>
            <div>
              <NuxtLink
                class="px-3 py-1 border border-green-200 mb-8 bg-white rounded hover:bg-green-300"
                :to="`/edit-doctor/${doctor.id}`"
                >Editar</NuxtLink
              >
            </div>
          </div>
          <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-900 mb-2">
              Horarios disponibles (Zona horaria - {{ _clientTimeZone }}):
            </h3>
            <div
              class="grid grid-cols-4 gap-2"
              v-if="
                doctor.parseAvalaibleHoraries &&
                doctor.parseAvalaibleHoraries.length
              "
            >
              <div
                v-for="(hour, _i) in doctor.parseAvalaibleHoraries"
                :key="_i"
                class="text-center"
              >
                <button
                  @click="onSelectHour(doctor.id, hour.hour)"
                  :disabled="hour.avalaible === false"
                  class="w-full px-2 py-1 text-sm font-medium rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300"
                  :class="{
                    'bg-gray-50 hover:bg-gray-50': hour.avalaible === false,
                    '!bg-blue-500 !hover:bg-blue900 text-white':
                      selectedHour.doctor === doctor.id &&
                      selectedHour.hour === hour.hour,
                  }"
                >
                  {{ addSufixTime(hour.hour) }}
                </button>
              </div>
              <div
                class="col-span-4 mt-2"
                v-if="selectedHour.doctor === doctor.id"
              >
                <button
                  @click="onReserve"
                  class="bg-green-500 px-4 py-2 rounded text-white hover:bg-green-800 w-full"
                >
                  Reservar
                </button>
              </div>
            </div>
            <div
              class="grid grid-cols-4 gap-2"
              v-else-if="
                doctor.avalable_horaries &&
                typeof doctor.avalable_horaries === 'string'
              "
            >
              <button
                @click="onSelectHour(doctor.id, doctor.avalable_horaries)"
                class="w-full px-2 py-1 text-sm font-medium rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300"
                :class="{
                  '!bg-blue-500 !hover:bg-blue900 text-white':
                    selectedHour.doctor === doctor.id &&
                    selectedHour.hour === doctor.avalable_horaries,
                }"
              >
                {{
                  addSufixTime(
                    parseDateToHourClient(
                      doctor.avalable_horaries,
                      doctor.time_zone
                    )
                  )
                }}
              </button>
              <div
                class="col-span-4 mt-2"
                v-if="selectedHour.doctor === doctor.id"
              >
                <button
                  @click="onReserve"
                  class="bg-green-500 px-4 py-2 rounded text-white hover:bg-green-800 w-full"
                >
                  Reservar
                </button>
              </div>
            </div>
            <p v-else class="text-gray-600">No hay horarios disponibles</p>
          </div>
        </div>
      </div>
    </div>
    <div class="flex justify-center mt-4" v-if="doctors.length === 0">
      <p>No hay doctores disponibles...</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { DoctorsAvailableData } from "~/types/Doctors";
import { storeReservations } from "~/services/doctors";
import { useGetReport } from "~/services/reports";
import { format } from "date-fns";

const today = new Date();

const todayFormated = format(today, "yyyy-MM-dd");

const pending = ref(false);

const doctors = ref([] as DoctorsAvailableData[]);

const { data } = await useGetDoctos(todayFormated, todayFormated);

const date = ref(today);
const date2 = ref(today);
const date3 = ref({
  start: today,
  end: today,
});
const rules = ref({
  minutes: {
    interval: 60,
  },
});

const dateSearch = ref() as Ref<Date>;

onMounted(async () => {
  if (data.value) {
    doctors.value = mapAvalaibleDay(data.value, date.value);
    dateSearch.value = date.value;
  }
});

const _clientTimeZone = clientTimeZone();

const searchAvalaibles = async () => {
  pending.value = true;
  const { data } = await useGetDoctos(
    format(date.value, "yyyy-MM-dd"),
    format(date.value, "yyyy-MM-dd")
  );
  if (!data.value) {
    pending.value = false;
    return;
  }
  doctors.value = mapAvalaibleDay(data.value, date.value);
  pending.value = false;
  dateSearch.value = date.value;
};

const selectedHour = ref({} as { doctor: string; hour: string });

const onSelectHour = (doctorId: string, hour: string) => {
  selectedHour.value = { doctor: doctorId, hour };
};

const Swal = useSwal();

const searchAvalaiblesOnTime = async () => {
  pending.value = true;

  const { data } = await useGetDoctorTime(date2.value);
  if (!data.value) {
    pending.value = false;
    return;
  }
  doctors.value = data.value;
  pending.value = false;
  dateSearch.value = date2.value;
};

const generateReport = async () => {
  const file = await useGetReport(date3.value);
  if (!file) {
    return Swal.fire(
      "Error",
      "Ocurrio un error al generar el reporte",
      "error"
    );
  }

  const url = window.URL.createObjectURL(new Blob([file]));
  const link = document.createElement("a");
  link.href = url;
  const date = format(date3.value.start, "yyyy-MM-dd");
  const dateEnd = format(date3.value.end, "yyyy-MM-dd");

  link.setAttribute(
    "download",
    `Reporte-disponiblidad-${date}-a-${dateEnd}.xlsx`
  );
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const onReserve = async () => {
  const confirm = await Swal.fire({
    title: "Estas Seguro?",
    text: "Deseas realizar esta reserva",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "No",
    confirmButtonText: "Si",
  });

  if (confirm.isConfirmed) {
    const resp = await storeReservations({
      employee_id: selectedHour.value.doctor,
      date: dateSearch.value,
      time: selectedHour.value.hour,
    });
    if (resp) {
      searchAvalaibles();
      return Swal.fire(
        "Reserva Realizada",
        "Tu reserva ha sido realizada",
        "success"
      );
    }
    return Swal.fire(
      "Error",
      "Ocurrio un error al realizar la reserva",
      "error"
    );
  }
};
</script>
