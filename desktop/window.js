function push(obj){
	window.parent.postMessage(obj,'*');
}
var bodyEvent=[];
function bodyAddEvent(eventName,fun){
	if(bodyEvent[eventName]==null){
		bodyEvent[eventName]=[];
		document.body.addEventListener(eventName,function(e){
			bodyEvent[eventName].forEach(function(get){get(e);});
		});
	}
	bodyEvent[eventName].push(fun);
}
var windownonload=()=>{};
window.onload=()=>{
	bodyAddEvent('click',()=>{
		push(['onclick']);
	});
	windownonload();
}