export interface DoctorsAvailableData {
  avalable_horaries: AvalableHorary[];
  email: string;
  fullname: string;
  id: string;
  phone: string;
  speciality: string;
  time_zone: string;
}

interface AvalableHorary {
  date: Date;
  hours: string[];
}
