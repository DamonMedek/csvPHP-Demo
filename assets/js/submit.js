$("#processCSV").on("click", function (e) {
  e.preventDefault();
  e.stopPropagation();
  $("body").animate(
    {
      backgroundColor: "#aa9df9",
    },
    1500
  );
  //upload File
  let formData = new FormData();
  let file = $("#csvHolder")[0].files[0];
  formData.append("file", file);
  $.ajax({
    url: "./assets/php/uploadFile.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
  }).done(function (fileLocation) {
    if (fileLocation != 0) {
      //PurgeCSVFile
      $.ajax({
        type: "POST",
        url: "./assets/php/csvReader.php",
        data: { fileLocation: fileLocation },
      }).done(function (data) {
        //Output CSV in Browser
        $.ajax({
          type: "POST",
          url: "./assets/php/csvInBrowser.php",
        }).done(function (data) {
          $("#ajax_updatedCSV").html(data);
        });

        //Save updated CSV File
        $.ajax({
          type: "GET",
          url: "./assets/php/save_updatedCSV.php",
        }).done(function (data) {
          window.location = "./assets/php/save_updatedCSV.php";
        });
      });
    } else {
      alert("failure with upload");
    }
  });
});
