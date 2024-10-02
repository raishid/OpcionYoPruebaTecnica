export interface DoctorsAvailableData {
  avalable_horaries: string[];
  email: string;
  fullname: string;
  id: string;
  phone: string;
  speciality: string;
  time_zone: string;
  parseAvalaibleHoraries?: { hour: string; avalaible: boolean }[];
  avalaible_hour?: string;
}

export interface storeDoctorData {
  name: string;
  last_name: string;
  email: string;
  phone: string;
  speciality: string;
  address: string;
  time_zone: string;
  hour_start: string | Date;
  hour_end: string | Date;
  lunch_start: string | Date;
  days: string[];
  lunch_end?: string | Date;
}

export interface Doctor {
  id: string;
  name: string;
  last_name: string;
  email: string;
  phone: string;
  speciality: string;
  address: string;
  time_zone: string;
  horaries: Horaries;
}

export interface Horaries {
  id: string;
  start: string;
  end: string;
  lunch_start: string;
  lunch_end: string;
  days: string[];
}
