        </div>

        </div>
        
        </div>

      </div>
    </div>
    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
      $('#toggle').click(function() {
        $('#sidebar').toggle('slide');
          $('.content').animate({
              'margin-left' : $('.content').css('margin-left') == '230px' ? '0px' : '230px'
          }, 300);
      });

      <?php if(isset($_GET['mensagem'])): ?>
        setTimeout(function(){
          $('#alert-mensagem').fadeOut();
          window.location.href =  window.location.href.split("?")[0];
        }, 5000);
     <?php endif; ?>
    </script>
  </body>
</html>