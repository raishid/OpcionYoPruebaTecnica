export default () => {
  return Intl.DateTimeFormat().resolvedOptions().timeZone;
};
