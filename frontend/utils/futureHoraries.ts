import { parse, format } from "date-fns";
export default (picker: Date) => {
  const todayD = format(new Date(), "yyyy-MM-dd");
  const pickerD = format(picker, "yyyy-MM-dd");

  if (pickerD > todayD) {
    picker.setHours(0, 0, 0, 0);
  }

  const futureHour = horaries().map((hour) => {
    const hourDate = parse(hour, "HH:mm", picker);

    if (hourDate > picker) {
      return hour;
    }
  });

  return futureHour.filter((hour) => hour) as string[] | [];
};
