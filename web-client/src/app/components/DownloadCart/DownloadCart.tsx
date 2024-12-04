import React, { useState } from "react";
import * as XLSX from "xlsx";
import jsPDF from "jspdf";

const DownloadCart = ({ monthlyData, quarterlyData, annualData }) => {
  const [selectedType, setSelectedType] = useState("");

  const handleDownloadExcel = (data, filename) => {
    const worksheet = XLSX.utils.json_to_sheet([data]); // Wrap data in an array for a single row
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Data");
    XLSX.writeFile(workbook, `${filename}.xlsx`);
  };

  const handleDownloadPDF = (data, filename) => {
    const doc = new jsPDF();
    doc.text(`Data Report: ${filename}`, 10, 10);
    let y = 20;

    // Create a single row summary for PDF
    doc.text(
      `Name: ${data.name}, Sales: ₱${data.sales}, Profit: ₱${data.profit}, Expenses: ₱${data.expenses}`,
      10,
      y
    );
    doc.save(`${filename}.pdf`);
  };

  const prepareData = () => {
    let data;
    let filename;

    switch (selectedType) {
      case "monthly":
        data = {
          name: "Monthly",
          sales: monthlyData
            .reduce((acc, item) => acc + item.sales, 0)
            .toFixed(2),
          profit: monthlyData
            .reduce((acc, item) => acc + item.profit, 0)
            .toFixed(2),
          expenses: monthlyData
            .reduce((acc, item) => acc + item.expenses, 0)
            .toFixed(2),
        };
        filename = "Monthly_Report";
        break;
      case "quarterly":
        data = {
          name: "Quarterly",
          sales: quarterlyData
            .reduce((acc, item) => acc + parseFloat(item.sales), 0)
            .toFixed(2),
          profit: quarterlyData
            .reduce((acc, item) => acc + parseFloat(item.profit), 0)
            .toFixed(2),
          expenses: quarterlyData
            .reduce((acc, item) => acc + parseFloat(item.expenses), 0)
            .toFixed(2),
        };
        filename = "Quarterly_Report";
        break;
      case "annual":
        data = {
          name: "Annual",
          sales: annualData[0].sales,
          profit: annualData[0].profit,
          expenses: annualData[0].expenses,
        };
        filename = "Annual_Report";
        break;
      default:
        return null; // Return null if no valid type is selected
    }

    return { data, filename };
  };

  const handleExcelDownload = () => {
    const { data, filename } = prepareData();
    if (data && filename) {
      handleDownloadExcel(data, filename); // Download as Excel
    }
  };

  const handlePDFDownload = () => {
    const { data, filename } = prepareData();
    if (data && filename) {
      handleDownloadPDF(data, filename); // Download as PDF
    }
  };

  return (
    <div className="bg-white p-4 rounded-lg shadow-lg flex flex-row items-center space-x-4">
      <div className="flex space-x-4">
        <h2 className="text-xl font-semibold mb-2">Download Data</h2>
        <label className="label-text text-gray-600">Select Data Type:</label>
        <select
          className="input input-bordered w-full bg-gray-50 text-gray-800"
          id="dataType"
          onChange={(e) => setSelectedType(e.target.value)}
        >
          <option value="">Select...</option>
          <option value="monthly">Monthly</option>
          <option value="quarterly">Quarterly</option>
          <option value="annual">Annual</option>
        </select>
      </div>
      <div className="flex space-x-4">
        <button
          onClick={handleExcelDownload}
          className="bg-blue-500 text-white px-4 py-2 rounded"
          disabled={!selectedType} // Disable button if no type is selected
        >
          Download Excel
        </button>
        <button
          onClick={handlePDFDownload}
          className="bg-green-500 text-white px-4 py-2 rounded"
          disabled={!selectedType} // Disable button if no type is selected
        >
          Download PDF
        </button>
      </div>
    </div>
  );
};

export default DownloadCart;
