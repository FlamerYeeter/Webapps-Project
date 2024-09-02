const monthlyBtn = document.getElementById('monthlyBtn');
const annualBtn = document.getElementById('annualBtn');
const graphContainer = document.getElementById('graphContainer');

monthlyBtn.addEventListener('click', showMonthlyIncome);
annualBtn.addEventListener('click', showAnnualIncome);

function showMonthlyIncome() {
    // Fetch data from the database for monthly income

    // Example data
    const monthlyData = [
        { month: 'January', income: 45000 },
        { month: 'February', income: 42000 },
        { month: 'March', income: 56000 },
        // Add more months and income data as needed
    ];

    const xValues = monthlyData.map(item => item.month);
    const yValues = monthlyData.map(item => item.income);

    const data = [{
        x: xValues,
        y: yValues,
        type: 'bar'
    }];

    const layout = {
        title: 'Monthly Income',
        xaxis: {
            title: 'Month'
        },
        yaxis: {
            title: 'Income'
        },
        autosize: true, // Enable automatic size adjustment
        margin: { t: 50, r: 20, l: 40, b: 40 } // Set margins for better visibility
    };

    const config = {
        responsive: true, // Enable responsiveness
        displayModeBar: false, // Disable the plotly.js mode bar
        staticPlot: true // Disable graph interaction and editing
    };

    Plotly.newPlot(graphContainer, data, layout, config);
    monthlyBtn.classList.add('active');
    annualBtn.classList.remove('active');
}

function showAnnualIncome() {
    // Fetch data from the database for annual income

    // Example data
    const annualData = [
        { year: 2021, income: 700000 },
        { year: 2022, income: 500000 },
        { year: 2023, income: 850000 },
        // Add more years and income data as needed
    ];

    const xValues = annualData.map(item => item.year);
    const yValues = annualData.map(item => item.income);

    const data = [{
        x: xValues,
        y: yValues,
        type: 'scatter',
        mode: 'lines'
    }];

    const layout = {
        title: 'Annual Income',
        xaxis: {
            title: 'Year'
        },
        yaxis: {
            title: 'Income'
        },
        autosize: true, // Enable automatic size adjustment
        margin: { t: 50, r: 20, l: 40, b: 40 } // Set margins for better visibility
    };

    const config = {
        responsive: true, // Enable responsiveness
        displayModeBar: false, // Disable the plotly.js mode bar
        staticPlot: true // Disable graph interaction and editing
    };

    Plotly.newPlot(graphContainer, data, layout, config);
    annualBtn.classList.add('active');
    monthlyBtn.classList.remove('active');
}
