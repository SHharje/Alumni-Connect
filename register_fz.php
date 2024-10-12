<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<style>
    body{
        background-color: lightblue;
    }
    form{
        background-color: lightgray;
        width: 50%;
        margin: auto;
        padding: 25px;
        border-radius: 10px;
    }
    input[type="submit"]{
        padding: 10px;
        background-color: green;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    input[type="submit"]:hover{
        background-color: darkgreen;
    }
    input[type="text"], input[type="email"], input[type="password"]{
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid black;
        border-radius: 5px;
    }
    label{
        font-weight: bold;
    }
    h3{
        color: green;
    }
</style>
   <form action="index.php" method="post">
    <h3><center>Welcome to Khulna Zilla School Alumni Association</center></h3>
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name"><br><br>
    <label for="phone number">Phone number:</label>
    <input type="text" id="phone number" name="phone number"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    <label for present address>Present Address:</label>
    <input type="text" id="present address" name="present address"><br><br>
    <label for permanent address>Permanent Address:</label>
    <input type="text" id="permanent Address" name="permanent Address"><br><br>
    

    <lable for="Last Section">Last Section:</label>
    <select name="Last Section" id="Last Section" name="Last Section">
        <option value="">Select Last Section</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
    </select><br><br>

    <lable for='Last Shift'>Last Shift:</label>
    <select name="Last Shift" id="Last Section">
        <option value="">Select Last Shift</option>
        <option value="Day">A</option>
        <option value="Morning">B</option>
        
    </select><br><br>

    <label for="date of birth">Date of birth</label>
        <input type="date" id="date of birth" name="date of birth"><br><br>





    <label for="blood group">Blood Group:</label>
    <select name="blood group" id="blood group">
        <option value="">Select Blood group</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option><br><br>

    </select><br><br>

    <label for="Last Roll">Last Roll:</label>
    <input type="text" id="Last Roll" name="Last Roll"><br><br>

    <label for="current-student">
                <input type="checkbox" id="current-student" name="current_student" onclick="toggleField()">
                I am a current student
            </label><br>

<div id="ssc-batch">
    <label for="SSC BATCH">SSC BATCH:</label>
    
<input type="number" placeholder="YYYY" min="1900" max="2100">
   <script>
      document.querySelector("input[type=number]")
      .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
   </script>
</div>

<div id="ssc-roll">
    <label for="SSC Roll">SSC Roll:</label>
    <input type="text" id="Last Roll" name="Last Roll">
</div>

<div id="ssc-reg-no">
    <label for="SSC reg NO ">SSC reg NO</label>
    <input type="text" id="Last Roll" name="Last Roll">
</div>

<div id="current-class" style= "display: none;">
    <label for ="Current Class">Current Class:</label>
    <select name="Current Class" id="Current Class">
        <option value="">Select Current Class</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="New 10">New 10</option>
        <option value="Old 10">Old 10</option>
        </select><br><br>
</div>

    <label for="image">Upload Your image:</label>
    <input type="file" id="image" name="image"><br><br>

    <input type="submit" value="Submit">



    <script>
        function toggleField() {
            const currentStudentCheckbox = document.getElementById('current-student');
            const sscbatch = document.getElementById('ssc-batch');
            const sscroll = document.getElementById('ssc-roll');
            const  sscreg = document.getElementById('ssc-reg-no');
            const cc = document.getElementById('current-class');
           

            if (currentStudentCheckbox.checked) {
                sscbatch.style.display = 'none';
                sscroll.style.display = 'none';
                sscreg.style.display = 'none';
                cc.style.display = 'block';
            } else {
                sscbatch.style.display = 'block';
                sscroll.style.display = 'block';
                sscreg.style.display = 'block';
                cc.style.display = 'none';
            }
        }
    </script>

    


    
   
    


   </form>
</body>
</html>



























