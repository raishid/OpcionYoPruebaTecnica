import Swal from "sweetalert2/dist/sweetalert2.js";

export const useSwal = () => {
  const {
    vueApp: {
      config: {
        globalProperties: { $swal },
      },
    },
  } = useNuxtApp();

  return $swal as typeof Swal;
};
