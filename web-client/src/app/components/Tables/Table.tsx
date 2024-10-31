"use client";

type TableProps = {
  title: string;
  data: any[]; // Array of data objects
  columns: Array<{ key: string; label: string }>; // Array of objects with key and label for headers
};

export default function Table({ title, data, columns }: TableProps) {
  return (
    <div className="overflow-x-auto bg-white border border-gray-300 p-4 rounded-lg shadow-md">
      <h3 className="text-lg font-bold">{title}</h3>
      <table className="table min-w-full mt-4">
        <thead>
          <tr className="bg-gray-100">
            <th className="border-b border-gray-100 p-2 text-left">
              <p className="font-bold text-black">#</p>
            </th>
            {columns.map((column) => (
              <th
                key={column.key}
                className="border-b border-gray-100 p-2 text-left"
              >
                <p className="font-bold text-black">{column.label}</p>
              </th>
            ))}
          </tr>
        </thead>
        <tbody>
          {data.length > 0 ? (
            data.slice(0, 5).map(
              (
                item,
                index // Limit to first 5 items
              ) => (
                <tr
                  key={item.id}
                  className={`hover:bg-gray-300 ${
                    index % 2 === 0 ? "bg-base-0" : ""
                  }`}
                >
                  <th className="border-b border-gray-300 p-2 text-left">
                    {index + 1}
                  </th>
                  {columns.map((column) => (
                    <td
                      key={column.key}
                      className="border-b border-gray-300 p-2"
                    >
                      {column.key === "price"
                        ? `₱ ${item[column.key].toFixed(2)}`
                        : item[column.key]}
                    </td>
                  ))}
                </tr>
              )
            )
          ) : (
            <tr>
              <td
                colSpan={columns.length + 1}
                className="border-b border-gray-300 p-2 text-center"
              >
                No data available
              </td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}
