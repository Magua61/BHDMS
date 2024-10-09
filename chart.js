google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawCharts);
function drawCharts() {
  console.log("Chart created");
  // BEGIN BAR CHART
  /*
  // create zero data so the bars will 'grow'
  var barZeroData = google.visualization.arrayToDataTable([
    ['Day', 'Page Views', 'Unique Views'],
    ['Sun',  0,      0],
    ['Mon',  0,      0],
    ['Tue',  0,      0],
    ['Wed',  0,      0],
    ['Thu',  0,      0],
    ['Fri',  0,      0],
    ['Sat',  0,      0]
  ]);
	*/
  // actual bar chart data
  var barData = google.visualization.arrayToDataTable([
    ['Day', 'Diabetes', 'Heart Attack', 'Flu'],
    ['0-10',  12,      2, 21],
    ['11-20',  230,      123, 780],
    ['21-30',  660,       400, 921],
    ['31-40',  1030,      540, 657],
    ['41-50',  1000,      790, 450],
    ['51-60',  1170,      960, 321],
    ['61+',  1370,       3000, 532]
  ]);
  // set bar chart options
  var barOptions = {
    focusTarget: 'category',
    backgroundColor: 'transparent',
    colors: ['cornflowerblue', 'tomato', 'yellow'],
    fontName: 'Open Sans',
    chartArea: {
      left: 50,
      top: 10,
      width: '100%',
      height: '70%'
    },
    bar: {
      groupWidth: '80%'
    },
    hAxis: {
      textStyle: {
        fontSize: 11
      }
    },
    vAxis: {
      minValue: 0,
      maxValue: 1500,
      baselineColor: '#DDD',
      gridlines: {
        color: '#DDD',
        count: 4
      },
      textStyle: {
        fontSize: 11
      }
    },
    legend: {
      position: 'bottom',
      textStyle: {
        fontSize: 12
      }
    },
    animation: {
      duration: 1200,
      easing: 'out',
			startup: true
    }
  };
  // draw bar chart twice so it animates
  var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
  //barChart.draw(barZeroData, barOptions);
  barChart.draw(barData, barOptions);
  
  var mentalHealthBarData = google.visualization.arrayToDataTable([
    ['Day', 'Depression', 'ADHD', 'Anxiety'],
    ['0-10',  12,      643, 21],
    ['11-20',  130,      323, 780],
    ['21-30',  760,       400, 921],
    ['31-40',  1120,      540, 657],
    ['41-50',  1230,      790, 450],
    ['51-60',  1170,      960, 321],
    ['61+',  1290,       3000, 532]
  ]);
  // set bar chart options
  var mentalHealthbarOptions = {
    focusTarget: 'category',
    backgroundColor: 'transparent',
    colors: ['cornflowerblue', 'tomato', 'yellow'],
    fontName: 'Open Sans',
    chartArea: {
      left: 50,
      top: 10,
      width: '100%',
      height: '70%'
    },
    bar: {
      groupWidth: '80%'
    },
    hAxis: {
      textStyle: {
        fontSize: 11
      }
    },
    vAxis: {
      minValue: 0,
      maxValue: 1500,
      baselineColor: '#DDD',
      gridlines: {
        color: '#DDD',
        count: 4
      },
      textStyle: {
        fontSize: 11
      }
    },
    legend: {
      position: 'bottom',
      textStyle: {
        fontSize: 12
      }
    },
    animation: {
      duration: 1200,
      easing: 'out',
			startup: true
    }
  };
  // draw bar chart twice so it animates
  var mentalHealthbarChart = new google.visualization.ColumnChart(document.getElementById('mental-bar-chart'));
  //barChart.draw(barZeroData, barOptions);
  mentalHealthbarChart.draw(mentalHealthBarData, mentalHealthbarOptions);
  
  function randomNumber(base, step) {
    return Math.floor((Math.random()*step)+base);
  }
  function createData(year, start1, start2, step, offset) {
    var ar = [];
    for (var i = 0; i < 12; i++) {
      ar.push([new Date(year, i), randomNumber(start1, step)+offset, randomNumber(start2, step)+offset]);
    }
    return ar;
  }
  var randomLineData = [
    ['Year', 'Flu', 'Diabetes']
  ];
  for (var x = 0; x < 7; x++) {
    var newYear = createData(2007+x, 10000, 5000, 4000, 800*Math.pow(x,2));
    for (var n = 0; n < 12; n++) {
      randomLineData.push(newYear.shift());
    }
  }
  var lineData = google.visualization.arrayToDataTable(randomLineData);
  
	/*
  var animLineData = [
    ['Year', 'Page Views', 'Unique Views']
  ];
  for (var x = 0; x < 7; x++) {
    var zeroYear = createData(2007+x, 0, 0, 0, 0);
    for (var n = 0; n < 12; n++) {
      animLineData.push(zeroYear.shift());
    }
  }
  var zeroLineData = google.visualization.arrayToDataTable(animLineData);
	*/

  var lineOptions = {
    backgroundColor: 'transparent',
    colors: ['cornflowerblue', 'tomato'],
    fontName: 'Open Sans',
    focusTarget: 'category',
    chartArea: {
      left: 50,
      top: 10,
      width: '100%',
      height: '70%'
    },
    hAxis: {
      //showTextEvery: 12,
      textStyle: {
        fontSize: 11
      },
      baselineColor: 'transparent',
      gridlines: {
        color: 'transparent'
      }
    },
    vAxis: {
      minValue: 0,
      maxValue: 50000,
      baselineColor: '#DDD',
      gridlines: {
        color: '#DDD',
        count: 4
      },
      textStyle: {
        fontSize: 11
      }
    },
    legend: {
      position: 'bottom',
      textStyle: {
        fontSize: 12
      }
    },
    animation: {
      duration: 1200,
      easing: 'out',
			startup: true
    }
  };

  var lineChart = new google.visualization.LineChart(document.getElementById('line-chart'));
  //lineChart.draw(zeroLineData, lineOptions);
  lineChart.draw(lineData, lineOptions);
  

}

function drawChart(vaccinated, unvaccinated) {
  var data = google.visualization.arrayToDataTable([
      ['Status', 'Number of People'],
      ['Vaccinated', vaccinated],
      ['Unvaccinated', unvaccinated],
  ]);

  var options = {
      backgroundColor: 'transparent',
      pieHole: 0.4,
      colors: ['cornflowerblue', 'crimson'],
      pieSliceText: 'value',
      tooltip: { text: 'percentage' },
      fontName: 'Open Sans',
      chartArea: { width: '100%', height: '94%' },
      legend: { textStyle: { fontSize: 13 } },
  };

  var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
  chart.draw(data, options);
}

// Function to update the pie chart based on the selected vaccine
function updatePieChart() {
  const vaccine = document.getElementById('vaccine-select').value;

  // Fetch the vaccination data from the server
  fetch('get_vaccination_data.php')
      .then(response => response.json())
      .then(data => {
          // Handle case where the selected vaccine is not found in the data
          if (data[vaccine]) {
              const vaccinated = data[vaccine].vaccinated;
              const unvaccinated = data[vaccine].unvaccinated;
              drawChart(vaccinated, unvaccinated);
          } else {
              // Handle the case where vaccine data is missing or invalid
              console.warn(`No data found for vaccine: ${vaccine}`);
              drawChart(0, 0); // Default to empty chart if data not found
          }
      })
      .catch(error => console.error('Error fetching vaccination data:', error));
}

// Load the initial chart when the page loads
google.charts.setOnLoadCallback(updatePieChart);


// Function to fetch user habits based on the selected sorting criteria
function fetchUserHabits(sortBy) {
  const url = `get_habits_by_${sortBy}.php`; // Dynamically set the URL based on sortBy
  fetch(url)
      .then(response => response.json())
      .then(data => {
          drawHabitsBarChart(data, sortBy); // Pass the sortBy parameter
      })
      .catch(error => {
          console.error('Error fetching habits data:', error);
      });
}

// Event listener for sorting
document.getElementById('habits-sort').addEventListener('change', function() {
  const sortBy = this.value; // Get the selected sorting option
  fetchUserHabits(sortBy); // Fetch data based on the selected criteria
});

// Function to draw the habits bar chart
function drawHabitsBarChart(data, sortBy) {
  const barData = [[sortBy === 'age' ? 'Age Group' : sortBy === 'ethnicity' ? 'Ethnicity' : sortBy === 'income' ? 'Income Group' : 'Education Level', 'Smokers', 'Drinkers', 'Drug Users']];
  
  for (const [key, counts] of Object.entries(data)) {
      barData.push([key, counts.smokers, counts.drinkers, counts.drug_users]);
  }

  const dataTable = google.visualization.arrayToDataTable(barData);

  const barOptions = {
      backgroundColor: 'transparent',
      colors: ['cornflowerblue', 'tomato', 'yellow'],
      hAxis: {
          title: sortBy === 'age' ? 'Age Group' : sortBy === 'ethnicity' ? 'Ethnicity' : sortBy === 'income' ? 'Income Group' : 'Education Level',
          minValue: 0,
      },
      vAxis: {
          title: 'Count',
          minValue: 0,
      },
      legend: { position: 'bottom' },
  };

  const barChart = new google.visualization.ColumnChart(document.getElementById('habits-bar-chart'));
  barChart.draw(dataTable, barOptions);
}

// Function to fetch user disease based on the selected sorting criteria
function fetchUserDisease(sortBy) {
  const url = `get_disease_by_${sortBy}.php`; // Dynamically set the URL based on sortBy
  fetch(url)
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          return response.json();
      })
      .then(data => {
          drawDiseaseBarChart(data, sortBy); // Pass the sortBy parameter
      })
      .catch(error => {
          console.error('Error fetching disease data:', error);
      });
}

// Event listener for sorting
document.getElementById('disease-sort').addEventListener('change', function() {
  const sortBy = this.value; // Get the selected sorting option
  fetchUserDisease(sortBy); // Fetch data based on the selected criteria
});

// Function to draw the disease bar chart
function drawDiseaseBarChart(data, sortBy) {
  const barData = [];
  const diseaseNames = new Set();
  for (const counts of Object.values(data)) {
    Object.keys(counts).forEach(disease => diseaseNames.add(disease));
  }

  // Convert the Set to an array for easier indexing
  const diseaseArray = Array.from(diseaseNames);

  // Step 2: Define the column headers based on the sortBy parameter
  const header = [
    sortBy === 'age' ? 'Age Group' :
    sortBy === 'ethnicity' ? 'Ethnicity' :
    sortBy === 'income' ? 'Income Group' : 
    'Education Level',
    ...diseaseArray // Add the dynamic disease names to the header
  ];
  barData.push(header);
  // Loop through the data to fill the barData array
  for (const [key, counts] of Object.entries(data)) {
    // Create a row starting with the key (e.g., age group)
    const row = [key];

    // Add the counts for each disease (or 0 if the disease is missing)
    diseaseArray.forEach(disease => {
      row.push(counts[disease] || 0); // Use 0 if the disease count is missing
    });

    barData.push(row); // Add the row to barData
  }

  const dataTable = google.visualization.arrayToDataTable(barData);

  const barOptions = {
      backgroundColor: 'transparent',
      colors: ['cornflowerblue', 'tomato', 'yellow', 'green', 'purple','pink'],

      hAxis: {
          title: 'Disease',
          minValue: 0,
      },
      vAxis: {
          title: 'Count',
          minValue: 0,
      },
      legend: { position: 'bottom' },
  };

  // Draw the chart
  const barChart = new google.visualization.ColumnChart(document.getElementById('disease-bar-chart'));
  barChart.draw(dataTable, barOptions);
}

// Function to fetch user disease based on the selected sorting criteria
function fetchUserMental(sortBy) {
  const url = `get_mental_by_${sortBy}.php`; // Dynamically set the URL based on sortBy
  fetch(url)
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          return response.json();
      })
      .then(data => {
          drawMentalBarChart(data, sortBy); // Pass the sortBy parameter
      })
      .catch(error => {
          console.error('Error fetching mental data:', error);
      });
}

// Event listener for sorting
document.getElementById('mental-sort').addEventListener('change', function() {
  const sortBy = this.value; // Get the selected sorting option
  fetchUserMental(sortBy); // Fetch data based on the selected criteria
});

// Function to draw the disease bar chart
function drawMentalBarChart(data, sortBy) {
  const barData =[];
  const mentalNames = new Set();
  for (const counts of Object.values(data)) {
    Object.keys(counts).forEach(mental => mentalNames.add(mental));
  }

  // Convert the Set to an array for easier indexing
  const mentalArray = Array.from(mentalNames);

  // Step 2: Define the column headers based on the sortBy parameter
  const header = [
    sortBy === 'age' ? 'Age Group' :
    sortBy === 'ethnicity' ? 'Ethnicity' :
    sortBy === 'income' ? 'Income Group' : 
    'Education Level',
    ...mentalArray // Add the dynamic disease names to the header
  ];
  barData.push(header);
  // Loop through the data to fill the barData array
  for (const [key, counts] of Object.entries(data)) {
    // Create a row starting with the key (e.g., age group)
    const row = [key];

    // Add the counts for each disease (or 0 if the disease is missing)
    mentalArray.forEach(mental => {
      row.push(counts[mental] || 0); // Use 0 if the disease count is missing
    });

    barData.push(row); // Add the row to barData
  }

  const dataTable = google.visualization.arrayToDataTable(barData);

  const barOptions = {
      backgroundColor: 'transparent',
      colors: ['cornflowerblue', 'tomato', 'yellow','green','purple','pink'],
      hAxis: {
          title: 'Mental Illness',
          minValue: 0,
      },
      vAxis: {
          title: 'Count',
          minValue: 0,
      },
      legend: { position: 'bottom' },
  };

  // Draw the chart
  const barChart = new google.visualization.ColumnChart(document.getElementById('mental-bar-chart'));
  barChart.draw(dataTable, barOptions);
}
// Function to initialize the chart on page load
function initChart() {
  fetchUserHabits('age'); // Default to age
  fetchUserDisease('age');
  fetchUserMental('age');
}

// Load the chart when the Google Charts library is loaded
google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(initChart); // Set the default chart to be age groups
