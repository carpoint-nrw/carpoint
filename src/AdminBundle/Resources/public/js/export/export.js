$(() => {
  if (fileName !== '') {
    location.href = `${exportExcel}/${fileName}`;
  }
});