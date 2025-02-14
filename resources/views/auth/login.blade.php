<!-- filepath: /C:/Users/Asus/Petshop/Petshop/resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script>
        async function login(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();
            if (response.ok) {
                alert('Login successful! Token: ' + data.token);
                localStorage.setItem('token', data.token); // เก็บ token ไว้ใช้งาน
            } else {
                alert('Login failed: ' + data.message);
            }
        }
    </script>
</head>
<body>
    <h2>Login</h2>
    <form onsubmit="login(event)">
        <label>Email:</label>
        <input type="email" id="email" required>
        <label>Password:</label>
        <input type="password" id="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
