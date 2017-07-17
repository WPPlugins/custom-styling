jQuery(document).ready(function($){
	var editor = CodeMirror.fromTextArea(document.getElementById("wpcs_styling"), {
	    lineNumbers: true,
	    mode: "css",
	    keyMap: "sublime",
	    autoCloseBrackets: true,
	    matchBrackets: true,
	    showCursorWhenSelecting: true,
	    theme: "mbo"
  	});
});