import { parse } from "date-fns";
export default (dateFilter: null | Date) => {
  console.log(dateFilter);

  let picker;
  if (dateFilter) {
    picker = dateFilter;
  } else {
    picker = new Date();
  }
  const now = new Date();
  const futureHour = horaries().map((hour) => {
    const hourDate = parse(hour, "HH:mm", now);
    if (hourDate > hourDate) {
      return hour;
    }
  });

  return futureHour.filter((hour) => hour) as string[] | [];
};
