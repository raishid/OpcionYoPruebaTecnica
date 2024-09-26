import { format } from "date-fns";
import type { storeDoctorData } from "~/types/Doctors";

type StoreReservation = {
  employee_id: string;
  date: Date | string;
  time: string;
  timezone?: string;
};

export const storeReservations = async (data: StoreReservation) => {
  const {
    public: { apiUrl },
  } = useRuntimeConfig();

  data.date = format(data.date, "yyyy-MM-dd");

  const _client_timezone = clientTimeZone();

  data.timezone = _client_timezone;

  try {
    await $fetch(`${apiUrl}/reservations`, {
      method: "post",
      headers: {
        accept: "application/json",
      },
      body: JSON.stringify(data),
    });

    return true;
  } catch (e) {
    console.log(e);

    return false;
  }
};

export const storeDoctors = async (data: storeDoctorData) => {
  const {
    public: { apiUrl },
  } = useRuntimeConfig();

  try {
    await $fetch(`${apiUrl}/employees`, {
      method: "post",
      headers: {
        accept: "application/json",
      },
      body: JSON.stringify(data),
    });

    return true;
  } catch (e) {
    console.log(e);

    return false;
  }
};

export const updateDoctors = async (data: storeDoctorData, id: string) => {
  const {
    public: { apiUrl },
  } = useRuntimeConfig();

  try {
    await $fetch(`${apiUrl}/employee/${id}`, {
      method: "put",
      headers: {
        accept: "application/json",
      },
      body: JSON.stringify(data),
    });

    return true;
  } catch (e) {
    console.log(e);

    return false;
  }
};
