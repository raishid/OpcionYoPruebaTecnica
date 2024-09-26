<template>
  <div
    class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
  >
    <div class="max-w-xl w-full space-y-8 bg-white p-6 rounded-xl shadow-md">
      <div class="flex justify-between items-center">
        <NuxtLink to="/" class="text-blue-500 mt-6">Volver</NuxtLink>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Registrar Doctor
        </h2>
        <div></div>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="onSubmit">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="nombre" class="sr-only">Nombre</label>
            <input
              id="nombre"
              v-model="formData.name"
              name="nombre"
              type="text"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Nombre"
            />
          </div>
          <div>
            <label for="apellido" class="sr-only">Apellido</label>
            <input
              id="apellido"
              v-model="formData.last_name"
              name="apellido"
              type="text"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Apellido"
            />
          </div>
          <div>
            <label for="email" class="sr-only">Email</label>
            <input
              id="email"
              v-model="formData.email"
              name="email"
              type="email"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Email"
            />
          </div>
          <div>
            <label for="telefono" class="sr-only">Teléfono</label>
            <input
              id="telefono"
              v-model="formData.phone"
              name="telefono"
              type="tel"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Teléfono"
            />
          </div>
          <div>
            <label for="especialidad" class="sr-only">Especialidad</label>
            <input
              id="especialidad"
              v-model="formData.speciality"
              name="especialidad"
              type="text"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Especialidad"
            />
          </div>
          <div>
            <label for="direccion" class="sr-only">Dirección</label>
            <input
              id="direccion"
              v-model="formData.address"
              name="direccion"
              type="text"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Dirección"
            />
          </div>
          <div>
            <label for="zonaHoraria" class="sr-only">Zona Horaria</label>
            <select
              id="zonaHoraria"
              v-model="formData.time_zone"
              name="zonaHoraria"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            >
              <option value="">Seleccione zona horaria</option>
              <option v-for="tz in tz.names()" :key="tz" :value="tz">
                {{ tz }}
              </option>
            </select>
          </div>
          <div class="flex items-center gap-2">
            <VDatePicker
              v-model="formData.hour_start"
              mode="time"
              is24hr
              hide-time-header
              :rules="rules"
            />
            <label for="horarioInicio">Horario de Inicio</label>
          </div>
          <div class="flex items-center gap-2">
            <VDatePicker
              v-model="formData.hour_end"
              mode="time"
              is24hr
              hide-time-header
              :rules="rules"
            />
            <label for="horarioFinal">Horario Final</label>
          </div>
          <div class="flex items-center gap-2">
            <VDatePicker
              v-model="formData.lunch_start"
              mode="time"
              is24hr
              hide-time-header
              :rules="rules"
            />
            <label for="horaAlmuerzo">Hora de Almuerzo</label>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mt-4"
              >Días de trabajo</label
            >
            <div class="mt-2 space-y-2">
              <div
                v-for="dia in diasSemana"
                :key="dia.value"
                class="flex items-center"
              >
                <input
                  :id="dia.value"
                  v-model="formData.days"
                  :value="dia.value"
                  type="checkbox"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                />
                <label
                  :for="dia.value"
                  class="ml-2 block text-sm text-gray-900"
                >
                  {{ dia.label }}
                </label>
              </div>
            </div>
          </div>
        </div>

        <div>
          <button
            :disabled="pending"
            type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { storeDoctors } from "~/services/doctors";
import { tz } from "moment-timezone";
import { format, addHours } from "date-fns";
import type { storeDoctorData } from "~/types/Doctors";

const currentTimezone = tz.guess(true);

const rules = ref({
  minutes: {
    interval: 60,
  },
});

const diasSemana = [
  {
    value: "Monday",
    label: "Lunes",
  },
  {
    value: "Tuesday",
    label: "Martes",
  },
  {
    value: "Wednesday",
    label: "Miércoles",
  },
  {
    value: "Thursday",
    label: "Jueves",
  },
  {
    value: "Friday",
    label: "Viernes",
  },
];

const date = new Date("0001-01-01T00:00:00");
const pending = ref(false);

const formData = ref({
  name: "",
  last_name: "",
  email: "",
  phone: "",
  speciality: "",
  address: "",
  time_zone: currentTimezone,
  hour_start: date,
  hour_end: date,
  lunch_start: date,
  days: [],
} as storeDoctorData);

const onSubmit = async () => {
  if (formData.value.days.length === 0) {
    alert("Debe seleccionar al menos un día de trabajo");
    return;
  }

  if (formData.value.hour_start >= formData.value.hour_end) {
    alert("La hora de inicio debe ser menor a la hora final");
    return;
  }

  if (formData.value.hour_start >= formData.value.lunch_start) {
    alert("La hora de inicio debe ser menor a la hora de almuerzo");
    return;
  }

  pending.value = true;

  const parsedData = {
    ...formData.value,
  };

  parsedData.hour_start = format(parsedData.hour_start, "HH:mm");
  parsedData.hour_end = format(parsedData.hour_end, "HH:mm");
  parsedData.lunch_end = format(addHours(parsedData.lunch_start, 1), "HH:mm");
  parsedData.lunch_start = format(parsedData.lunch_start, "HH:mm");

  const resp = await storeDoctors(parsedData);

  const Swal = useSwal();

  if (resp) {
    Swal.fire({
      title: "Doctor registrado",
      text: "El doctor ha sido registrado exitosamente",
      icon: "success",
    });

    formData.value = {
      name: "",
      last_name: "",
      email: "",
      phone: "",
      speciality: "",
      address: "",
      time_zone: currentTimezone,
      hour_start: date,
      hour_end: date,
      lunch_start: date,
      days: [],
    };
  } else {
    Swal.fire({
      title: "Error",
      text: "Ha ocurrido un error al registrar el doctor",
      icon: "error",
    });
  }

  pending.value = false;
};
</script>
