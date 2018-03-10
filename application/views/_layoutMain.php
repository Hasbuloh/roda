<?php $this->load->view('components/page_head');?>
<body>
		<?php $this->load->view($nav); ?>
    <section>
      <article class="container-fluid">
        <?php $this->load->view($subview);?>
      </article>
    </section>
    <hr>
    <footer>
      <div class="container"><p>SIIV Sistem Informasi Inventori &copy; Roda Mas Auto Lestari 2017</p></div>
    </footer>
<?php $this->load->view('components/page_tail'); ?>
