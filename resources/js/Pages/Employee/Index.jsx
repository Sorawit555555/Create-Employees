import { useState } from "react";
import { router } from '@inertiajs/react';
import './index.css';

// query ค่าของการค้นหาที่ส่งกลับมาจาก controller
// employees ข้อมูลพนักงานที่ส่งกลับมาจาก controller
export default function Index({ employees, query }) {

    const [search, setSearch] = useState(query || '');
    const [sortedEmployees, setSortedEmployees] = useState(employees.data);
    const [sortConfig, setSortConfig] = useState({ column: 'emp_no', order: 'asc' });

    const handleSearch = (e) => {
        e.preventDefault();

        // ส่งค่าที่ค้นหาไปที่ route โดยใช้ query คือค่าที่เราพิมพ์ในช่อง input
        // search คือค่าที่เราพิมพ์ในช่อง input
        router.get('/employee', { search });
    };

    // ฟังก์ชันสำหรับการจัดเรียงข้อมูลตามคอลัมน์
    const handleSortChange = (column, order) => {
        setSortConfig({ column, order });

        const sortedData = [...sortedEmployees].sort((a, b) => {
            if (a[column] < b[column]) {
                return order === 'asc' ? -1 : 1;
            }
            if (a[column] > b[column]) {
                return order === 'asc' ? 1 : -1;
            }
            return 0;
        });

        setSortedEmployees(sortedData);
    };

    return (
        <div>
            <h1>Employee List</h1>
            <form onSubmit={handleSearch} className="mb-4">
                <input
                    type="text"
                    value={search}
                    onChange={(e) => setSearch(e.target.value)} />
                <button type="submit">
                    Search
                </button>
            </form>

            <div className="sort-controls">
                <label htmlFor="column-select">Sort by:</label>
                <select
                    id="column-select"
                    value={sortConfig.column}
                    onChange={(e) => handleSortChange(e.target.value, sortConfig.order)}
                >
                    <option value="emp_no">ID</option>
                    <option value="first_name">First Name</option>
                    <option value="last_name">Last Name</option>
                    <option value="birth_date">Birthday</option>
                </select>

                <label htmlFor="order-select">Order:</label>
                <select
                    id="order-select"
                    value={sortConfig.order}
                    onChange={(e) => handleSortChange(sortConfig.column, e.target.value)}
                >
                    <option value="asc">A-Z</option>
                    <option value="desc">Z-A</option>
                </select>
            </div>

            {/* แสดงข้อความหากไม่มีข้อมูล */}
            {sortedEmployees.length === 0 ? (
                <p>ไม่มีข้อมูล</p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Birthday</th>
                        </tr>
                    </thead>
                    <tbody>
                        {sortedEmployees.map((employee) => (
                            <tr key={employee.emp_no}>
                                <td>{employee.emp_no}</td>
                                <td>{employee.first_name}</td>
                                <td>{employee.last_name}</td>
                                <td>{employee.birth_date}</td>
                            </tr>
                         //รับค่า employees มาจาก Controller เเล้ว map เพื่อวนลูปข้อมูลเเสดงผลในตาราง
                        ))}
                    </tbody>
                </table>
            )}

            <div className="pagination">
                <button onClick={() => employees.prev_page_url && window.location.assign(employees.prev_page_url)} disabled={!employees.prev_page_url}>
                    Previous
                </button>
                <span>Page {employees.current_page} of {employees.last_page}</span>
                <button onClick={() => employees.next_page_url && window.location.assign(employees.next_page_url)} disabled={!employees.next_page_url}>
                    Next
                </button>
            </div>
        </div>
    );
}
