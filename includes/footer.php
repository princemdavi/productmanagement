<footer>
    <div>
        <h1>&copy; copyright 2021</h1>
    </div>
</footer>
<script>

    (function(){


        var nav = document.querySelector('nav')
        var anchors = document.querySelectorAll('nav a')

        var current = window.location.pathname.split('/')
        current = current[current.length - 1]

        anchors.forEach(anchor => {

            var anchor_path = anchor.href.split("/");
            anchor_path = anchor_path[anchor_path.length - 1]

            console.log(current)
            
            if( anchor_path == current){
               anchor.className = "active"
            }
            
        })

        
    })()

</script>
</body>
</html>