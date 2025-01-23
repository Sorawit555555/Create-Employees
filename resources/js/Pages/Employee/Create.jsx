import { useForm, usePage } from '@inertiajs/react';

const CreateEmployee = () => {
    const { departments } = usePage().props;
    const { data, setData, post, errors } = useForm({
        birth_date: '',
        first_name: '',
        last_name: '',
        gender: '',
        hire_date: '',
        department: '',
        //เป็นตัวแปรที่ใช้เก็บข้อมูลที่จะส่งไปยัง Controller เพื่อบันทึกข้อมูล
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('employee.store'));
        //ส่งข้อมูลไปยัง employee.store
    };

    return (
        <form onSubmit={handleSubmit} className="max-w-lg mx-auto p-4 bg-white shadow-md rounded-lg">

            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2">Birth Date</label>
                <input
                    type="date"
                    value={data.birth_date}
                    onChange={(e) => setData('birth_date', e.target.value)}
                    required
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                />
                {errors.birth_date && <div className="text-red-500 text-xs mt-1">{errors.birth_date}</div>}
            </div>
            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                <input
                    type="text"
                    value={data.first_name}
                    onChange={(e) => setData('first_name', e.target.value)}
                    required
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                />
                {errors.first_name && <div className="text-red-500 text-xs mt-1">{errors.first_name}</div>}
            </div>
            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                <input
                    type="text"
                    value={data.last_name}
                    onChange={(e) => setData('last_name', e.target.value)}
                    required
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                />
                {errors.last_name && <div className="text-red-500 text-xs mt-1">{errors.last_name}</div>}
            </div>
            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                <select
                    value={data.gender}
                    onChange={(e) => setData('gender', e.target.value)}
                    required
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                    <option value="">Select Gender</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
                {errors.gender && <div className="text-red-500 text-xs mt-1">{errors.gender}</div>}
            </div>
            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2">Hire Date</label>
                <input
                    type="date"
                    value={data.hire_date}
                    onChange={(e) => setData('hire_date', e.target.value)}
                    required
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                />
                {errors.hire_date && <div className="text-red-500 text-xs mt-1">{errors.hire_date}</div>}
            </div>
            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2">Department</label>
                <select
                    value={data.department}
                    onChange={(e) => setData('department', e.target.value)}
                    required
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                    <option value="">Select Department</option>
                    {departments.map((dept) => (
                        <option key={dept.dept_no} value={dept.dept_no}>
                            {dept.dept_name}
                        </option>
                    ))}
                </select>
                {errors.department && <div className="text-red-500 text-xs mt-1">{errors.department}</div>}
            </div>

            <button type="submit" className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Create Employee
            </button>
        </form>
    );
};

export default CreateEmployee;



