(function(){
    var wall;
    var dataList;
    var concurrentLoadings = 2;
    var currentIndex = 0;

    function init()
    {
        wall = document.querySelector('#wall');
        dataList = JSON.parse(wall.getAttribute("data-images"));
        console.log(dataList);
        concurrentLoadings = wall.getAttribute("data-concurrent-loading")||concurrentLoadings;

        for(var i = 0; i<concurrentLoadings; i++)
        {
            newImage();
        }
    }

    function newImage()
    {
        if(currentIndex >= dataList.length)
        {
            console.log("loading completed");
            return;
        }

        var data = dataList[currentIndex];

        var span = document.createElement('span');
        span.style.width = data.size[0]+"px";
        span.style.height = data.size[1]+"px";
        span.classList.add('loading');

        var img = document.createElement('img');
        img.setAttribute('src', data.path);
        img.setAttribute('width', data.size[0]);
        img.setAttribute("height", data.size[1]);
        img.style.opacity = 0;
        img.addEventListener('load', imageLoadedHandler, false);

        span.appendChild(img);
        wall.appendChild(span);

        currentIndex++;
    }

    function imageLoadedHandler(e)
    {
        var image = e.currentTarget;
        M4Tween.to(image,.3, {opacity:1});
        image.parentNode.classList.remove('loading');
        newImage();
    }

    window.addEventListener('DOMContentLoaded', init, false);
})();