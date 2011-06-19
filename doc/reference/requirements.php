<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Requirements for running Symfony2</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="requirements-for-running-symfony2">
      <span id="index-0"></span><h1>Requirements for running Symfony2<a class="headerlink" href="#requirements-for-running-symfony2" title="Permalink to this headline">¶</a></h1>
      <p>To run Symfony2, your system needs to adhere to a list of requirements. You can
	easily see if your system passes all requirements by running the <tt class="docutils literal"><span class="pre">web/config.php</span></tt>
	in your symfony distribution. Since the CLI often uses a different <tt class="docutils literal"><span class="pre">php.ini</span></tt>
	configuration file, it's also a good idea to check your requirements from
	the command line via:</p>
      <div class="highlight-bash"><div class="highlight"><pre>php app/check.php
	</pre></div>
      </div>
      <p>Below is the list of required and optional requirements.</p>
      <div class="section" id="required">
	<h2>Required<a class="headerlink" href="#required" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li>PHP needs to be a minimum version of PHP 5.3.2</li>
	  <li>Your PHP.ini needs to have the date.timezone setting</li>
	</ul>
      </div>
      <div class="section" id="optional">
	<h2>Optional<a class="headerlink" href="#optional" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><p class="first">You need to have the PHP-XML module installed</p>
	  </li>
	  <li><p class="first">You need to have at least version 2.6.21 of libxml</p>
	  </li>
	  <li><p class="first">PHP tokenizer needs to be enabled</p>
	  </li>
	  <li><p class="first">mbstring functions need to be enabled</p>
	  </li>
	  <li><p class="first">iconv needs to be enabled</p>
	  </li>
	  <li><p class="first">POSIX needs to be enabled</p>
	  </li>
	  <li><p class="first">Intl needs to be installed</p>
	  </li>
	  <li><p class="first">APC (or another opcode cache needs to be installed)</p>
	  </li>
	  <li><p class="first">PHP.ini recommended settings</p>
	    <blockquote>
	      <div><ul class="simple">
		  <li>short_open_tags: off</li>
		  <li>magic_quotes_gpc: off</li>
		  <li>register_globals: off</li>
		  <li>session.autostart: off</li>
		</ul>
	    </div></blockquote>
	  </li>
	</ul>
      </div>
      <div class="section" id="doctrine">
	<h2>Doctrine<a class="headerlink" href="#doctrine" title="Permalink to this headline">¶</a></h2>
	<p>If you want to use Doctrine, you will need to have PDO installed. Additionally,
	  you need to have the PDO driver installed for the database server you want
	  to use.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="YAML" href="YAML.html">
      «&nbsp;YAML
    </a><span class="separator">|</span>
    <a accesskey="N" title="Introduction to the &quot;Model&quot;" href="model.html">
      Introduction to the "Model"&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
