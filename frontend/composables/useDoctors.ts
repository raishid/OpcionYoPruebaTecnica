import type { DoctorsAvailableData, Doctor } from "~/types/Doctors";
import { getUnixTime } from "date-fns";
export const useGetDoctos = async (start_time: string, end_time: string) => {
  const {
    public: { apiUrl },
  } = useRuntimeConfig();
  return useFetch<DoctorsAvailableData[]>(
    `${apiUrl}/employe-avalaible-horaries`,
    {
      headers: {
        accept: "application/json",
      },
      params: {
        start_time: start_time,
        end_time: end_time,
        /* timezone: clientTimeZone(), */
      },
    }
  );
};

export const useGetDoctorTime = (date: Date) => {
  const timestamp = getUnixTime(date);
  const {
    public: { apiUrl },
  } = useRuntimeConfig();
  return useFetch<DoctorsAvailableData[]>(`${apiUrl}/employee-avalaible`, {
    headers: {
      accept: "application/json",
    },
    params: {
      time_request: timestamp,
      timezone: clientTimeZone(),
    },
  });
};

export const useGetDoctor = async (id: string) => {
  const {
    public: { apiUrl },
  } = useRuntimeConfig();
  return useFetch<Doctor>(`${apiUrl}/employee/${id}`, {
    headers: {
      accept: "application/json",
    },
  });
};
