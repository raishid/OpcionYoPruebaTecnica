import { format } from "date-fns";
type dd = {
  start: Date | string;
  end: Date | string;
};
export const useGetReport = async (date: dd) => {
  const {
    public: { apiUrl },
  } = useRuntimeConfig();

  date.start = format(date.start, "yyyy-MM-dd");
  date.end = format(date.end, "yyyy-MM-dd");

  const { data } = await useFetch(`${apiUrl}/report-reservations`, {
    params: {
      start_time: date.start,
      end_time: date.end,
    },
  });

  return data.value as Blob | null;
};
