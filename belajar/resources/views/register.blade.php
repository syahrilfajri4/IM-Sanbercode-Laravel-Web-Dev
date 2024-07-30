<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Buat Account Baru!</h1>
    <h3>Sign Up Form</h3>
    <form action="{{ route('process_register') }}" method="POST">
        @csrf
        <label for="first_name">First Name:</label><br><br>
        <input type="text" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label><br><br>
        <input type="text" name="last_name" required><br><br>

        <label for="gender">Gender:</label><br><br>
        <input type="radio" name="gender" value="Male"> Male <br>
        <input type="radio" name="gender" value="Female"> Female <br>
        <input type="radio" name="gender" value="Other"> Other <br><br>

        <label for="nationality">Nationality:</label> <br><br>
        <select name="nationality" id="nationality">
            <option value="Bahasa Indonesia">Bahasa Indonesia</option>
            <option value="English">English</option>
            <option value="Other">Other</option>
        </select> <br><br>

        <label for="language_spoken">Language Spoken:</label><br><br>
        <input type="checkbox" name="language_spoken[]" value="Bahasa Indonesia"> Bahasa Indonesia <br>
        <input type="checkbox" name="language_spoken[]" value="English"> English <br>
        <input type="checkbox" name="language_spoken[]" value="Arabic"> Arabic <br>
        <input type="checkbox" name="language_spoken[]" value="Other"> Other <br><br>

        <label for="bio">Bio:</label> <br><br>
        <textarea name="bio" rows="10" cols="25"></textarea> <br><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
