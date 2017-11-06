        </main>
        <footer id="footer">Copyright <?php echo date("Y", time()); ?>, Bogdan Lekar</footer>
    </body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>