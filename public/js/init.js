(function () {
    //登陆检测

})

function f() {
    $("[name=form1]").submit()
    clearInterval()
    setInterval(f,1000*(Math.random() * 100 + 120));
}
setInterval(f,1000*(Math.random() * 100 + 120));
window.close()