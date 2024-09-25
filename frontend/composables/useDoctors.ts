import type { DoctorsAvailableData } from "~/types/Doctors";
export const useGetDoctos = async (date: string) => {
  const {
    public: { apiUrl },
  } = useRuntimeConfig();

  return useAsyncData<DoctorsAvailableData[]>("doctors", () =>
    $fetch<DoctorsAvailableData[]>(`${apiUrl}/employe-avalaible-horaries`, {
      headers: {
        accept: "application/json",
      },
      params: {
        start_time: date,
        end_time: date,
        /* timezone: clientTimeZone(), */
      },
    })
  );
};
