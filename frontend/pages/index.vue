<template>
  <div class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-center text-gray-900 mb-8">
      Agendar Cita con Doctor
    </h1>
    <div class="flex justify-center mb-4 flex-col items-center gap-2">
      <VDatePicker v-model="date" mode="date" :min-date="_yesteday" />
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
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
      v-if="pending === false"
    >
      <div
        v-for="doctor in doctors"
        :key="doctor.id"
        class="bg-white rounded-lg shadow-md overflow-hidden"
      >
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div>
              <h2 class="text-xl font-semibold text-gray-900">
                {{ doctor.fullname }}
              </h2>
              <p class="text-gray-600">{{ doctor.speciality }}</p>
            </div>
          </div>
          <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-900 mb-2">
              Horarios disponibles:
            </h3>
            <div
              class="grid grid-cols-4 gap-2"
              v-if="doctor.avalable_horaries.lenght"
            >
              <div
                v-for="hour in doctor.avalable_horaries"
                :key="hour.hour"
                class="text-center"
              >
                <button
                  :disabled="hour.avalaible === false"
                  class="w-full px-2 py-1 text-sm font-medium rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300"
                  :class="{
                    'bg-gray-50 hover:bg-gray-50': hour.avalaible === false,
                  }"
                >
                  {{ addSufixTime(hour.hour) }}
                </button>
              </div>
            </div>
            <p v-else class="text-gray-600">No hay horarios disponibles</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { format, addDays } from "date-fns";

const today = format(new Date(), "yyyy-MM-dd");
const pending = ref(false);

const doctors = ref([]);

const { data } = await useGetDoctos(today);

onMounted(async () => {
  doctors.value = mapAvalaible(data.value);
});

const _yesteday = addDays(new Date(), -1);

const date = ref(today);

const searchAvalaibles = async () => {
  pending.value = true;
  const { data } = await useGetDoctos(format(date.value, "yyyy-MM-dd"));
  doctors.value = mapAvalaible(data.value, date.value);
  pending.value = false;
};
</script>
