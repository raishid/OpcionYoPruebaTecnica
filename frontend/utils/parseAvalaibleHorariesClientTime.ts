import { formatInTimeZone } from "date-fns-tz";
export default (horaries: string[], time_zone: string) => {
  return horaries.map((_hour) => {
    const hourTimeZone = formatInTimeZone(
      _hour,
      time_zone,
      "yyyy-MM-dd HH:mm:ssXXX"
    );

    const _clientTimeZone = clientTimeZone();

    const hourClientTimeZoneString = formatInTimeZone(
      hourTimeZone,
      _clientTimeZone,
      "HH:mm"
    );

    return hourClientTimeZoneString;
  });
};
