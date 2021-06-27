function validateform()
{
  var username=document.getElementById('username');
  var userid=document.getElementById('userid');
  var password=document.getElementById('password');
  var email=document.getElementById('email');
  var age=document.getElementById('age');
  var gender=document.querySelector('input[name="inlineRadioOptions"]:checked');
  var address=document.getElementById('address');
  var branch=document.getElementById('branch');
  var numberOfChecked = $('input:checkbox:checked').length;
  var resume=document.getElementById('customFile');
  var alphaExp = /^[a-zA-Z]+$/;

  if(username.value=="")
  {
    window.alert("Please enter your name");
    username.focus();
    return false;
  }
  else if(username.value.length>25)
  {
    window.alert("Name length should be less than or equal to 25");
    username.value="";
    username.focus();
    return false;
  }
  else if(!username.value.match(/^[a-zA-Z\s]+$/))
  {
    window.alert("Name must contain characters only")
    username.value="";
    username.focus();
    return false;
  }
  if(userid.value=="")
  {
    window.alert("Please enter your ID");
    userid.focus();
    return false;
  }
  if(password.value=="")
  {
    window.alert("Please enter a password");
    password.focus();
    return false;
  }
  if(email.value=="")
  {
    window.alert("Please enter your e-mail");
    email.focus();
    return false;
  }
  if(age.value=="")
  {
    window.alert("Please enter your age");
    age.focus();
    return false;
  }
  else if(!(age.value>=18 && age.value<=23))
  {
    window.alert("Age must be between 18 and 23")
    age.value="";
    age.focus();
    return false;
  }
  if(gender == null)
  {
    window.alert("Please select your gender");
    return false;
  }
  if(address.value=="")
  {
    window.alert("Please enter your address");
    address.focus();
    return false;
  }
  if(branch.value=="")
  {
    window.alert("Please select your branch");
    branch.focus();
    return false;
  }
  if(numberOfChecked==0)
  {
    window.alert("Please select your skills");
    return false;
  }
  else if(numberOfChecked<2)
  {
    window.alert("Atleast 2 skills must be selected");
    return false;
  }
  if(resume.value=="")
  {
    window.alert("Please upload your resume");
    resume.focus();
    return false;
  }
}
