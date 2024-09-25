export default (time: string) => {
  // Add sufix time
  const timeParsed = time.split(":");
  const hour = timeParsed[0];
  const minute = timeParsed[1];
  const sufix = parseInt(hour) >= 12 ? "PM" : "AM";

  return `${hour}:${minute} ${sufix}`;
};
