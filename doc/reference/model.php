<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Introduction to the "Model"</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="introduction-to-the-model">
      <span id="index-0"></span><h1>Introduction to the "Model"<a class="headerlink" href="#introduction-to-the-model" title="Permalink to this headline">¶</a></h1>
      <p>If you wanted to learn more about fashion models and supermodels, then this
	section won't be helpful to you. But if you're looking to learn about the
	model - the layer in your application that manages data - then keep reading.
	The Model description in this section is the one used when talking about
	<em>Model-View-Controller</em> applications.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">Model-View-Controller (MVC) is an application design pattern
	    originally introduced by Trygve Reenskaug for the Smalltalk
	    platform. The main idea of MVC is separating presentation from the
	    data and separating the controller from presentation. This kind of
	    separation lets each part of the application focus on exactly one
	    goal. The controller focuses on changing the data of the Model, the Model
	    exposes its data for the View, and the View focuses on creating
	    representations of the Model (e.g. an HTML page displaying "Blog Posts").</p>
      </div></div>
      <p>For example, when a user goes to your blog homepage, the user's browser sends
	a request, which is passed to the Controller responsible for rendering
	posts. The Controller calculates which posts should be displayed, retrieves
	<tt class="docutils literal"><span class="pre">Post</span></tt> Models from the database and passes that array to the View. The
	View renders HTML that is interpreted by the browser.</p>
      <div class="section" id="what-is-a-model-anyway">
	<h2>What is a Model anyway?<a class="headerlink" href="#what-is-a-model-anyway" title="Permalink to this headline">¶</a></h2>
	<p>The <em>Model</em> is what the "M" in "<a class="reference external" href="http://en.wikipedia.org/wiki/Model-View-Controller">MVC</a>" stands for. It is one of the three
	  whales of an MVC application. A model is responsible for changing its
	  internal state based on requests from the <a class="reference internal" href="../quick_tour/the_controller.html"><em>controller</em></a> and giving its current state information
	  to the <a class="reference internal" href="../book/templating.html"><em>view</em></a>. It is the main
	  application logic container.</p>
	<p>For example, if you are building a blog, then you'll have a <tt class="docutils literal"><span class="pre">Post</span></tt>
	  model. If you're building a content management system, then you will
	  need a <tt class="docutils literal"><span class="pre">Page</span></tt> model.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span>

<span class="k">namespace</span> <span class="nx">Blog</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Post</span>
<span class="p">{</span>
    <span class="k">private</span> <span class="nv">$title</span><span class="p">;</span>
    <span class="k">private</span> <span class="nv">$body</span><span class="p">;</span>
    <span class="k">private</span> <span class="nv">$createdAt</span><span class="p">;</span>
    <span class="k">private</span> <span class="nv">$updatedAt</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nv">$title</span><span class="p">,</span> <span class="nv">$body</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">title</span>     <span class="o">=</span> <span class="nv">$title</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">body</span>      <span class="o">=</span> <span class="nv">$body</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createdAt</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">\DateTime</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setTitle</span><span class="p">(</span><span class="nv">$title</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">title</span>     <span class="o">=</span> <span class="nv">$title</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">updatedAt</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">\DateTime</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setBody</span><span class="p">(</span><span class="nv">$body</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">body</span>      <span class="o">=</span> <span class="nv">$body</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">updatedAt</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">\DateTime</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getTitle</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">title</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getBody</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">body</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>It is obvious that the above class is very simple and testable, yet it's
	  mostly complete and will fulfill all the needs of a simple blogging
	  engine.</p>
	<p>That's it! You now know what a Model in Symfony2 is: it is any class
	  that you want to save into some sort of data storage mechanism and
	  retrieve later. The rest of the chapter is dedicated to explaining how
	  to interact with the database.</p>
      </div>
      <div class="section" id="databases-and-symfony2">
	<h2>Databases and Symfony2<a class="headerlink" href="#databases-and-symfony2" title="Permalink to this headline">¶</a></h2>
	<p>It is worth noting that Symfony2 doesn't come with an object relational
	  mapper (ORM) or database abstraction layer (DBAL) of its own; this is
	  just not the problem Symfony2 is meant to solve. However, Symfony2 provides
	  deep integration with libraries like <a class="reference external" href="http://www.doctrine-project.org/">Doctrine</a> and <a class="reference external" href="http://www.propelorm.org/">Propel</a>, which <em>do</em>
	  provide ORM and DBAL packages, letting you use whichever one you like best.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The acronym "ORM" stands for "Object Relational Mapping" and
	      represents a programming technique of converting data between
	      incompatible type systems. Say we have a <tt class="docutils literal"><span class="pre">Post</span></tt>, which is stored as
	      a set of columns in a database, but represented by an instance of
	      class <tt class="docutils literal"><span class="pre">Post</span></tt> in your application. The process of transforming
	      the database table into an object is called <em>object relation mapping</em>.
	      We will also see that this term is slightly outdated, as it is used in
	      dealing with relational database management systems. Nowadays there are
	      tons of non-relational data storage mechanism available. One such mechanism
	      is the <em>document oriented database</em> (e.g. MongoDB), which uses a
	      new term, "Object Document Mapping" or "ODM".</p>
	</div></div>
	<p>Going forward, you'll learn about the <a class="reference external" href="http://www.doctrine-project.org/projects/orm">Doctrine2 ORM</a> and Doctrine2
	  <a class="reference external" href="http://www.doctrine-project.org/projects/mongodb_odm">MongoDB ODM</a> (which serves as an ODM for <a class="reference external" href="http://www.mongodb.org">MongoDB</a> - a popular document
	  store) as both have the deepest integration with Symfony2 at the time of
	  this writing.</p>
      </div>
      <div class="section" id="a-model-is-not-a-table">
	<h2>A Model is not a Table<a class="headerlink" href="#a-model-is-not-a-table" title="Permalink to this headline">¶</a></h2>
	<p>The perception of a model class as a database table, where each object
	  instance represents a single row, was popularized by the Ruby on Rails
	  framework and the <a class="reference external" href="http://martinfowler.com/eaaCatalog/activeRecord.html">Active Record</a> design pattern. This is a good way of first
	  thinking about the model layer of your application, especially if you're
	  exposing a simple <a class="reference external" href="http://en.wikipedia.org/wiki/Create,_read,_update_and_delete">CRUD</a> (Create, Retrieve, Update, Delete) interface
	  for modifying the data of a model.</p>
	<p>But this approach can actually cause problems once you're past the CRUD part
	  of your application and start adding more business logic. Here are
	  the common limitations of the above-described approach:</p>
	<ul class="simple">
	  <li>Designing a schema before the actual software that will utilize it is
	    like digging a hole before knowing what you need to bury.
	    The item might fit in the hole you dig, but what if you're burying a
	    large firetruck? This requires an entirely different approach if you want
	    to do the job efficiently.</li>
	  <li>A database should be tailored to fit your application's needs, not the
	    other way around.</li>
	  <li>Some data storage engines (like document databases) don't have a notion
	    of tables, rows or even a schema, making it hard to use them if your
	    perception of a model is that which represents a table.</li>
	  <li>Keeping database schema in your head while designing your application
	    domain is problematic, and following the rule of the lowest common
	    denominator will give you the worst of both worlds.</li>
	</ul>
	<p>The <a class="reference external" href="http://www.doctrine-project.org/projects/orm">Doctrine2 ORM</a> is designed to remove the need to keep database
	  structure in mind and let you concentrate on writing the cleanest
	  possible models that will satisfy your business needs. It lets you design
	  your classes and their interactions first, before requiring you to even
	  think about <em>how</em> to persist your data.</p>
      </div>
      <div class="section" id="paradigm-shift">
	<h2>Paradigm Shift<a class="headerlink" href="#paradigm-shift" title="Permalink to this headline">¶</a></h2>
	<p>With the introduction of Doctrine2, some of the core paradigms have
	  shifted. <a class="reference external" href="http://domaindrivendesign.org/">Domain Driven Design</a> (DDD) teaches us that objects are best
	  modeled when modeled after their real-world prototypes. For example a <tt class="docutils literal"><span class="pre">Car</span></tt>
	  object is best modeled to contain <tt class="docutils literal"><span class="pre">Engine</span></tt>, four instances of
	  <tt class="docutils literal"><span class="pre">Tire</span></tt>, etc. and should be produced by <tt class="docutils literal"><span class="pre">CarFactory</span></tt> - something that
	  knows how to assemble all the parts together. Domain driven design deserves
	  a book in its own, as the concept is rather broad. However, for the purposes
	  of this chapter, it should be clear that a car cannot start by itself, there
	  must be an external impulse to start it. In a similar manner, a model cannot
	  save itself without an external impulse, therefore the following piece of
	  code violates DDD and will be troublesome to redesign in a clean, testable way.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$post</span><span class="o">-&gt;</span><span class="na">save</span><span class="p">();</span>
	  </pre></div>
	</div>
	<p>Hence, Doctrine2 is not your typical <a class="reference external" href="http://martinfowler.com/eaaCatalog/activeRecord.html">Active Record</a> implementation anymore.
	  Instead Doctrine2 uses a different set of patterns, most importantly the
	  <a class="reference external" href="http://martinfowler.com/eaaCatalog/dataMapper.html">Data Mapper</a> and <a class="reference external" href="http://martinfowler.com/eaaCatalog/unitOfWork.html">Unit Of Work</a> patterns. The following example shows
	  how to save an entity with Doctrine2:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$manager</span> <span class="o">=</span> <span class="c1">//... get object manager instance</span>

<span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$post</span><span class="p">);</span>
<span class="nv">$manager</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>
	  </pre></div>
	</div>
	<p>The "object manager" is a central object provided by Doctrine whose job
	  is to persist objects. You'll soon learn much more about this service.
	  This paradigm shift lets us get rid of any base classes (e.g. <tt class="docutils literal"><span class="pre">Post</span></tt>
	  doesn't need to extend a base class) and static dependencies. Any object
	  can be saved into a database for later retrieval. More than that, once persisted,
	  an object is managed by the object manager until the manager is explicitly
	  cleared. This means all object interactions happen in memory,
	  without ever going to the database until <tt class="docutils literal"><span class="pre">$manager-&gt;flush()</span></tt> is
	  called. Needless to say, this provides an instant database and query
	  optimization compared to most other object persistence patterns, as all
	  queries are as lazy as possible (i.e. their execution is deferred until the
	  latest possible moment).</p>
	<p>A very important aspect of the Active Record pattern is performance, or
	  rather, the <em>difficulty</em> in building a performant system. By using transactions
	  and in-memory object change tracking, Doctrine2 minimizes communication
	  with the database, saving not only database execution time, but also
	  expensive network communication.</p>
      </div>
      <div class="section" id="conclusion">
	<h2>Conclusion<a class="headerlink" href="#conclusion" title="Permalink to this headline">¶</a></h2>
	<p>Thanks to Doctrine2, the Model is now probably the simplest concept in
	  Symfony2: it is in your complete control and not limited by persistence
	  specifics.</p>
	<p>By teaming up with Doctrine2 to keep your code relieved of persistence
	  details, Symfony2 makes building database-aware applications even
	  simpler. Application code stays clean, which will decrease development
	  time and improve understandability of the code.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Requirements for running Symfony2" href="requirements.html">
      «&nbsp;Requirements for running Symfony2
    </a><span class="separator">|</span>
    <a accesskey="N" title="Contributing" href="../contributing/index.html">
      Contributing&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
