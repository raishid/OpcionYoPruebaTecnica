export default (horaries: string[], time_zone: string) => {
  return horaries.map((_hour) => {
    return parseDateToHourClient(_hour, time_zone);
  });
};
