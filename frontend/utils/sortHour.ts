type Ihorario = {
  hour: string;
  avalaible: boolean;
};
export default (horarios: Ihorario[]) => {
  horarios.sort((a, b) => {
    let timeA = new Date(`1970-01-01T${a.hour}:00`);
    let timeB = new Date(`1970-01-01T${b.hour}:00`);
    //@ts-ignore
    return timeA - timeB;
  });

  return horarios;
};
