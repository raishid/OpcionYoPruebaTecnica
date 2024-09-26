import { formatInTimeZone } from "date-fns-tz";

export default (date: string, timezone: string) => {
  const hourTimeZone = formatInTimeZone(
    date,
    timezone,
    "yyyy-MM-dd HH:mm:ssXXX"
  );

  const _clientTimeZone = clientTimeZone();

  const hourClientTimeZoneString = formatInTimeZone(
    hourTimeZone,
    _clientTimeZone,
    "HH:mm"
  );

  return hourClientTimeZoneString;
};
