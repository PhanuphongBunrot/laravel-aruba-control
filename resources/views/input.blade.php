<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document</title>
</head>
<body>


<script type="text/javascript">
    function fncSubmit()
{
    let form = document.form1
    if(form.master.value == "")
    {
        alert('กรุณากรอก IP ด้วยครับ!!!');
        return false;
    }else if(form.add.value == ""){
        alert('กรุณากรอก ที่อยู่ ด้วยครับ!!!');
        return false;
    }else if(form.long.value == ""){
        alert('กรุณากรอก พิกกัด ด้วยครับ!!!');
        return false;
    }else if(form.lati.value == ""){
        alert('กรุณากรอก พิกกัด ด้วยครับ!!!');
        return false;
    }
}
</script>

<h1>MasterIP</h1>
<form name="form1"action="input" method="POST"  onSubmit="JavaScript:return fncSubmit();">
    @csrf
    <input type="text" name= "master" placeholder="ระบุ IP มาสเตอร์"/><br><br>
    <input type="text" name= "add" placeholder="ระบุ ชื่อที่อยู่"/><br><br>
    <input type="text" name= "long" placeholder="ระบุ พิกกัด"/>,<input type="text" name= "lati" placeholder="ระบุ พิกกัด"/><br><br>
    
    <button type="submit">save</button>
</form>

</body>
</html>
