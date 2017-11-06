        </main>
        <script src="javascripts/script.js"></script>
        <footer id="footer">Copyright <?php echo date("Y", time()); ?>, Bogdan Lekar</footer>
    </body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>