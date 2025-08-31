//===================================== Chart 1 ==================================
{
const xValues = ["Laki-Laki", "Perempuan"];
const yValues = [1943, 2718];
const barColors = ["#00aba9", "magenta"];

new Chart("myChart1", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Jenis Kelamin"
    }
  }
});
}
// ================================== Chart 2 =======================================
{
const xValues = ["PNS", "PPPK"];
const yValues = [4661, 1730];
const barColors = [ "blue", "green"];

new Chart("myChart2", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Status Kepegawaian"
    }
  }
});
}

//============================= Chart 3 =========================
{
const xValues = ["18-20", "21-25", "26-30", "31- 35", "36- 40", "41- 45", "45-50", "51-55", "55-60", "diatas 60"];
const yValues = [0, 4, 177, 289, 784, 1155, 749, 741, 762, 0];
const barColors = "#00aba9";

new Chart("myChart3", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },

    title: {
      display: true,
      text: "Usia ASN"
    }
  }
});
}

//============================= Chart 4 =========================
{
const xValues = ["JPT", "Administrator", "Pengawas", "Pelaksana", "Fungsional"];
const yValues = [29, 170, 343, 831, 3288];
const barColors = "#00aba9";

new Chart("myChart4", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },

    title: {
      display: true,
      text: "Jabatan"
    }
  }
});
}

//============================= Chart 5 =========================
{
const xValues = ["Gol I", "Gol II", "Gol III", "Gol IV"];
const yValues = [10, 553, 3183, 915];
const barColors = "#00aba9";

new Chart("myChart5", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },

    title: {
      display: true,
      text: "Golongan"
    }
  }
});
}

//============================= Chart 6 =========================
{
const xValues = ["Eselon I", "Eselon II", "Eselon III", "Eselon IV", "Eselon V"];
const yValues = [0, 29, 170, 318, 0];
const barColors = "#00aba9";

new Chart("myChart6", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },

    title: {
      display: true,
      text: "Eselon"
    }
  }
});
}

//============================= Chart 7 =========================
{
const xValues = ["SD", "SLTP", "SLTA", "DI", "DII", "DII", "DIV", "S1", "S2", "S3"];
const yValues = [6, 11, 612, 13, 119, 742, 91, 4476, 317, 4];
const barColors = "#00aba9";

new Chart("myChart7", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },

    title: {
      display: true,
      text: "Pendidikan"
    }
  }
});
}

//============================= Chart 8 =========================
{
const xValues = ["Februari", "April", "Juni", "Agustus", "Oktober", "Desember" ];
const yValues = [10, 93, 119, 115, 118, 93 ];
const barColors = "#00aba9";

new Chart("myChart8", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },

    title: {
      display: true,
      text: "Kenaikan Pangkat Tahun 2024"
    }
  }
});
}