<footer>
    <div class="footer">
        <h3>&copy; copyright 2021</h3>
    </div>
</footer>
<script>

    function openModel(){

        document.querySelector(".modal__wrapper").style.opacity = "1"
        document.querySelector(".modal__wrapper").style.zIndex = "999"

    }

    (function(){


        var nav = document.querySelector('nav')
        var anchors = document.querySelectorAll('nav a')

        var current = window.location.pathname.split('/')
        current = current[current.length - 1]

        anchors.forEach(anchor => {

            var anchor_path = anchor.href.split("/");
            anchor_path = anchor_path[anchor_path.length - 1]
            
            if( anchor_path == current){
               anchor.className = "active"
            }
            
        })

        
    })()

</script>
</body>
</html>