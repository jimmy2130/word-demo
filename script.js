var currentDate = document.querySelector(".currentDate");

n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
if(d < 10)
	d = "0" + d;
if(m < 10)
	m = "0" + m;

currentDate.value = y + "-" + m + "-" + d;