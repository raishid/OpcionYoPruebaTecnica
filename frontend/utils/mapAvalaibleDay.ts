import type { DoctorsAvailableData } from "~/types/Doctors";
export default (doctors: DoctorsAvailableData[], dateFilter: Date) => {
  const _horaries = futureHoraries(dateFilter);

  return doctors.map((doc) => {
    let parseAvalaibleHoraries = [] as string[];
    if (doc.avalable_horaries && typeof doc.avalable_horaries[0] === "object") {
      parseAvalaibleHoraries = parseAvalaibleHorariesClientTime(
        doc.avalable_horaries[0],
        doc.time_zone
      );
    }

    const avalaibleHoraries = _horaries.map((hour) => {
      if (parseAvalaibleHoraries.includes(hour)) {
        return {
          hour: hour,
          avalaible: true,
        };
      }
      return {
        hour: hour,
        avalaible: false,
      };
    });

    const filterhorary = avalaibleHoraries.filter((hour) => hour.avalaible);

    const sortedHoraries = sortHour(filterhorary);

    return {
      ...doc,
      parseAvalaibleHoraries: sortedHoraries,
    };
  });
};
