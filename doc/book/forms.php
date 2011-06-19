<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">
 <div class="box_title">
    <h1 class="title_01">Forms</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="forms">
      <span id="index-0"></span><h1>Forms<a class="headerlink" href="#forms" title="Permalink to this headline">¶</a></h1>
      <p>Dealing with HTML forms is one of the most common - and challenging - tasks for
	a web developer. Symfony2 integrates a Form component that makes dealing with
	forms easy. In this chapter, you'll build a complex form from the ground-up,
	learning the most important features of the form library along the way.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The Symfony form component is a standalone library that can be used outside
	    of Symfony2 projects. For more information, see the <a class="reference external" href="https://github.com/symfony/Form">Symfony2 Form Component</a>
	    on Github.</p>
      </div></div>
      <div class="section" id="creating-a-simple-form">
	<span id="index-1"></span><h2>Creating a Simple Form<a class="headerlink" href="#creating-a-simple-form" title="Permalink to this headline">¶</a></h2>
	<p>Suppose you're building a simple store application that will need to display
	  products. Because your users will need to edit and create products, you're
	  going to need to build a form. But before you begin, let's focus on the generic
	  <tt class="docutils literal"><span class="pre">Product</span></tt> class that represents and stores the data for a single product:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Entity/Product.php</span>
<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Entity</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="k">protected</span> <span class="nv">$price</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getPrice</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">price</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setPrice</span><span class="p">(</span><span class="nv">$price</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">price</span> <span class="o">=</span> <span class="nv">$price</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p>If you're coding along with this example, be sure to create and enable
	      the <tt class="docutils literal"><span class="pre">AcmeStoreBundle</span></tt>. Run the following command and follow the on-screen
	      directions:</p>
	    <div class="last highlight-text"><div class="highlight"><pre>php app/console init:bundle Acme/StoreBundle src/
	      </pre></div>
	    </div>
	</div></div>
	<p>This type of class is commonly called a "plain-old-PHP-object" because, so far,
	  it has nothing to do with Symfony or any other library. It's quite simply a
	  normal PHP object that directly solves a problem inside <em>your</em> application (i.e.
	  the need to represent a product in your application). Of course, by the end of
	  this chapter, you'll be able to submit data to a <tt class="docutils literal"><span class="pre">Product</span></tt> instance (via a
	  form), validate its data, and persist it to a database.</p>
	<p>So far, you haven't actually done any work related to "forms" - you've simply
	  created a PHP class that will help you solve a problem in <em>your</em> application.
	  The goal of the form built in this chapter will be to allow your users to
	  interact with the data of a <tt class="docutils literal"><span class="pre">Product</span></tt> object.</p>
	<div class="section" id="building-the-form">
	  <h3>Building the Form<a class="headerlink" href="#building-the-form" title="Permalink to this headline">¶</a></h3>
	  <p>Now that you've created a <tt class="docutils literal"><span class="pre">Product</span></tt> class, the next step is to create and
	    render the actual HTML form. In Symfony2, this is done by building a form
	    object and then rendering it in a template. This can all be done from inside
	    a controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Controller/DefaultController.php</span>
<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Controller</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\StoreBundle\Entity\Product</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">DefaultController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// create a product and give it some dummy data for this example</span>
        <span class="nv">$product</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Product</span><span class="p">();</span>
        <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">name</span> <span class="o">=</span> <span class="s1">'Test product'</span><span class="p">;</span>
        <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">setPrice</span><span class="p">(</span><span class="s1">'50.00'</span><span class="p">);</span>

        <span class="nv">$form</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createFormBuilder</span><span class="p">(</span><span class="nv">$product</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'name'</span><span class="p">,</span> <span class="s1">'text'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'money'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'currency'</span> <span class="o">=&gt;</span> <span class="s1">'USD'</span><span class="p">))</span>
            <span class="o">-&gt;</span><span class="na">getForm</span><span class="p">();</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Default:index.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'form'</span> <span class="o">=&gt;</span> <span class="nv">$form</span><span class="o">-&gt;</span><span class="na">createView</span><span class="p">(),</span>
        <span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Later, when you add validation to the <tt class="docutils literal"><span class="pre">Product</span></tt> object, you'll learn
		that there is an even shorter way to configure the fields of the form. This
		is covered later in the <a class="reference internal" href="#book-forms-field-guessing"><em>Field Type Guessing</em></a> section.</p>
	  </div></div>
	  <p>Creating a form is short and easy in Symfony2 because form objects are built
	    via a "form builder". A form builder is an object you can interact with to
	    help you easily create form objects.</p>
	  <p>In this example, you've added two fields to your form - <tt class="docutils literal"><span class="pre">name</span></tt> and <tt class="docutils literal"><span class="pre">price</span></tt> -
	    corresponding to the <tt class="docutils literal"><span class="pre">name</span></tt> and <tt class="docutils literal"><span class="pre">price</span></tt> properties of the <tt class="docutils literal"><span class="pre">Product</span></tt> class.
	    The <tt class="docutils literal"><span class="pre">name</span></tt> field has a type of <tt class="docutils literal"><span class="pre">text</span></tt>, meaning the user will submit simple
	    text for this field. The <tt class="docutils literal"><span class="pre">price</span></tt> field has the type <tt class="docutils literal"><span class="pre">money</span></tt>, which is
	    special <tt class="docutils literal"><span class="pre">text</span></tt> field where money can be displayed and submitted in a localized
	    format. Symfony2 comes with many build-in types that will be discussed shortly
	    (see <a class="reference internal" href="#book-forms-type-reference"><em>Built-in Field Types</em></a>).</p>
	  <p>Now that the form has been created, the next step is to render it. This can
	    be easily done by passing a special form "view" object to your template (see
	    the <tt class="docutils literal"><span class="pre">$form-&gt;createView()</span></tt> in the controller above) and using a set of form
	    helper functions:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 184px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/StoreBundle/Resources/views/Default/index.html.twig #}</span>

<span class="nt">&lt;form</span> <span class="na">action=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'store_product'</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span> <span class="na">method=</span><span class="s">"post"</span> <span class="cp">{{</span> <span class="nv">form_enctype</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span><span class="nt">&gt;</span>
    <span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>

    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"submit"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/form&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="c1">// src/Acme/StoreBundle/Resources/views/Default/index.html.php ?&gt;</span>

<span class="o">&lt;</span><span class="nx">form</span> <span class="nx">action</span><span class="o">=</span><span class="s2">"&lt;?php echo </span><span class="si">$view['router']</span><span class="s2">-&gt;generate('store_product') ?&gt;"</span> <span class="nx">method</span><span class="o">=</span><span class="s2">"post"</span> <span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">enctype</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span> &gt;
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span>

    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"submit"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/form&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <img alt="../_images/forms-simple.png" class="align-center" src="../_images/forms-simple.png">
	  <p>That's it! By printing <tt class="docutils literal"><span class="pre">form_widget(form)</span></tt>, each field in the form is
	    rendered, along with a label and eventual error messages. As easy as this is,
	    it's not very flexible (yet). Later, you'll learn how to customize the form
	    output.</p>
	  <p>Before moving on, notice how the rendered name input field has the value
	    of the <tt class="docutils literal"><span class="pre">name</span></tt> property from the <tt class="docutils literal"><span class="pre">$product</span></tt> object (i.e. "Test product").
	    This is the first job of a form: to take data from an object and translate
	    it into a format that's suitable for being rendered in an HTML form.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The form system is smart enough to access the value of the protected
		<tt class="docutils literal"><span class="pre">price</span></tt> property via the <tt class="docutils literal"><span class="pre">getPrice()</span></tt> and <tt class="docutils literal"><span class="pre">setPrice()</span></tt> methods on the
		<tt class="docutils literal"><span class="pre">Product</span></tt> class. Unless a property is public, it <em>must</em> have a "getter" and
		"setter" method so that the form component can get and put data onto the
		property. For a Boolean property, you can use an "isser" method (e.g.
		<tt class="docutils literal"><span class="pre">isPublished()</span></tt>) instead of a getter (e.g. <tt class="docutils literal"><span class="pre">getPublished()</span></tt>).</p>
	  </div></div>
	</div>
	<div class="section" id="handling-form-submissions">
	  <h3>Handling Form Submissions<a class="headerlink" href="#handling-form-submissions" title="Permalink to this headline">¶</a></h3>
	  <p>The second job of a form is to translate user-submitted data back to the
	    properties of an object. To make this happen, the submitted data from the
	    user must be bound to the form. Add the following functionality to your
	    controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="c1">// just setup a fresh $product object (no dummy data)</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Product</span><span class="p">();</span>

    <span class="nv">$form</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createFormBuilder</span><span class="p">(</span><span class="nv">$product</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'name'</span><span class="p">,</span> <span class="s1">'text'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'money'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'currency'</span> <span class="o">=&gt;</span> <span class="s1">'USD'</span><span class="p">))</span>
        <span class="o">-&gt;</span><span class="na">getForm</span><span class="p">();</span>

    <span class="nv">$request</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">);</span>
    <span class="k">if</span> <span class="p">(</span><span class="nv">$request</span><span class="o">-&gt;</span><span class="na">getMethod</span><span class="p">()</span> <span class="o">==</span> <span class="s1">'POST'</span><span class="p">)</span> <span class="p">{</span>
        <span class="nv">$form</span><span class="o">-&gt;</span><span class="na">bindRequest</span><span class="p">(</span><span class="nv">$request</span><span class="p">);</span>

        <span class="k">if</span> <span class="p">(</span><span class="nv">$form</span><span class="o">-&gt;</span><span class="na">isValid</span><span class="p">())</span> <span class="p">{</span>
            <span class="c1">// perform some action, such as save the object to the database</span>

            <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">redirect</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateUrl</span><span class="p">(</span><span class="s1">'store_product_success'</span><span class="p">));</span>
        <span class="p">}</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Now, when submitting the form, the controller binds the submitted data to the
	    form, which translates that data back to the <tt class="docutils literal"><span class="pre">name</span></tt> and <tt class="docutils literal"><span class="pre">price</span></tt> properties
	    of the <tt class="docutils literal"><span class="pre">$product</span></tt> object. This all happens via the <tt class="docutils literal"><span class="pre">bindRequest()</span></tt> method.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p>As soon as <tt class="docutils literal"><span class="pre">bindRequest()</span></tt> is called, the submitted data is transferred
		to the underlying object immediately. For example, imagine that <tt class="docutils literal"><span class="pre">Foo</span></tt>
		is submitted for the <tt class="docutils literal"><span class="pre">name</span></tt> field:</p>
	      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$product</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Product</span><span class="p">();</span>
<span class="nv">$product</span><span class="o">-&gt;</span><span class="na">name</span> <span class="o">=</span> <span class="s1">'Test product'</span><span class="p">;</span>

<span class="nv">$form</span><span class="o">-&gt;</span><span class="na">bindRequest</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">));</span>
<span class="k">echo</span> <span class="nv">$product</span><span class="o">-&gt;</span><span class="na">name</span><span class="p">;</span>
		</pre></div>
	      </div>
	      <p class="last">The above statement will echo <tt class="docutils literal"><span class="pre">Foo</span></tt>, because <tt class="docutils literal"><span class="pre">bindRequest</span></tt> ultimately
		moves the submitted data back to the <tt class="docutils literal"><span class="pre">$product</span></tt> object.</p>
	  </div></div>
	  <p>This controller follows a common pattern for handling forms, and has three
	    possible paths:</p>
	  <ol class="arabic simple">
	    <li>When initially loading the form in a browser, the request method is <tt class="docutils literal"><span class="pre">GET</span></tt>,
	      meaning that the form is simply created and rendered (but not bound);</li>
	    <li>When the user submits the form (i.e. the method is <tt class="docutils literal"><span class="pre">POST</span></tt>), but that
	      submitted data is invalid (validation is covered in the next section),
	      the form is bound and then rendered, this time displaying all validation
	      errors;</li>
	    <li>When the user submits the form with valid data, the form is bound and
	      you have the opportunity to perform some actions using the <tt class="docutils literal"><span class="pre">$product</span></tt>
	      object (e.g. persisting it to the database) before redirecting the user
	      to some other page (e.g. a "thank you" or "success" page).</li>
	  </ol>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Redirecting a user after a successful form submission prevents the user
		from being able to hit "refresh" and re-post the data.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="form-validation">
	<span id="index-2"></span><h2>Form Validation<a class="headerlink" href="#form-validation" title="Permalink to this headline">¶</a></h2>
	<p>In the previous section, you learned how a form can be submitted with valid
	  or invalid data. In Symfony2, validation is applied to the underlying object
	  (e.g. <tt class="docutils literal"><span class="pre">Product</span></tt>). In other words, the question isn't whether the "form"
	  is valid, but rather whether or not the <tt class="docutils literal"><span class="pre">$product</span></tt> object is valid after
	  the form has applied the submitted data to it. Calling <tt class="docutils literal"><span class="pre">$form-&gt;isValid()</span></tt>
	  is a shortcut that asks the <tt class="docutils literal"><span class="pre">$product</span></tt> object whether or not it has valid
	  data.</p>
	<p>Validation is done by adding a set of rules (called constraints) to a class. To
	  see this in action, add validation constraints so that the <tt class="docutils literal"><span class="pre">name</span></tt> field cannot
	  be empty and the <tt class="docutils literal"><span class="pre">price</span></tt> field cannot be empty and must be a non-negative
	  number:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 202px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/StoreBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\StoreBundle\Entity\Product</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">name</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
        <span class="l-Scalar-Plain">price</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Min</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">0</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/StoreBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\StoreBundle\Entity\Product"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"name"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"price"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Min"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;value&gt;</span>0<span class="nt">&lt;/value&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/StoreBundle/Entity/Product.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     * @Assert\Min(0)</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$price</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/StoreBundle/Entity/Product.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\Min</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'name'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>

        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Min</span><span class="p">(</span><span class="mi">0</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>That's it! If you re-submit the form with invalid data, you'll see the
	  corresponding errors printed out with the form.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">If you have a look at the generated HTML code, the Form component generates
	      new HTML5 fields including a special "required" attribute to enforce some
	      validation directly via the web browser. Some of modern web browsers like
	      Firefox 4, Chrome 3.0 or Opera 9.5 understand this special "required"
	      attribute.</p>
	</div></div>
	<p>Validation is a very powerful feature of Symfony2 and has its own
	  <a class="reference internal" href="validation.html"><em>dedicated chapter</em></a>.</p>
      </div>
      <div class="section" id="built-in-field-types">
	<span id="book-forms-type-reference"></span><span id="index-3"></span><h2>Built-in Field Types<a class="headerlink" href="#built-in-field-types" title="Permalink to this headline">¶</a></h2>
	<p>Symfony comes standard with a large group of field types that cover all of
	  the common form fields and data types you'll encounter:</p>
	<div class="section" id="text-fields">
	  <h3>Text Fields<a class="headerlink" href="#text-fields" title="Permalink to this headline">¶</a></h3>
	  <ul class="simple">
	    <li><a class="reference internal" href="../reference/forms/types/text.html"><em>text</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/textarea.html"><em>textarea</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/email.html"><em>email</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/integer.html"><em>integer</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/money.html"><em>money</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/number.html"><em>number</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/password.html"><em>password</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/percent.html"><em>percent</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/search.html"><em>search</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/url.html"><em>url</em></a></li>
	  </ul>
	</div>
	<div class="section" id="choice-fields">
	  <h3>Choice Fields<a class="headerlink" href="#choice-fields" title="Permalink to this headline">¶</a></h3>
	  <ul class="simple">
	    <li><a class="reference internal" href="../reference/forms/types/choice.html"><em>choice</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/entity.html"><em>entity</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/country.html"><em>country</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/language.html"><em>language</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/locale.html"><em>locale</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/timezone.html"><em>timezone</em></a></li>
	  </ul>
	</div>
	<div class="section" id="date-and-time-fields">
	  <h3>Date and Time Fields<a class="headerlink" href="#date-and-time-fields" title="Permalink to this headline">¶</a></h3>
	  <ul class="simple">
	    <li><a class="reference internal" href="../reference/forms/types/date.html"><em>date</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/datetime.html"><em>datetime</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/time.html"><em>time</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/birthday.html"><em>birthday</em></a></li>
	  </ul>
	</div>
	<div class="section" id="other-fields">
	  <h3>Other Fields<a class="headerlink" href="#other-fields" title="Permalink to this headline">¶</a></h3>
	  <ul class="simple">
	    <li><a class="reference internal" href="../reference/forms/types/checkbox.html"><em>checkbox</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/file.html"><em>file</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/radio.html"><em>radio</em></a></li>
	  </ul>
	</div>
	<div class="section" id="field-groups">
	  <h3>Field Groups<a class="headerlink" href="#field-groups" title="Permalink to this headline">¶</a></h3>
	  <ul class="simple">
	    <li><a class="reference internal" href="../reference/forms/types/collection.html"><em>collection</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/repeated.html"><em>repeated</em></a></li>
	  </ul>
	</div>
	<div class="section" id="hidden-fields">
	  <h3>Hidden Fields<a class="headerlink" href="#hidden-fields" title="Permalink to this headline">¶</a></h3>
	  <ul class="simple">
	    <li><a class="reference internal" href="../reference/forms/types/hidden.html"><em>hidden</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/csrf.html"><em>csrf</em></a></li>
	  </ul>
	</div>
	<div class="section" id="base-fields">
	  <h3>Base Fields<a class="headerlink" href="#base-fields" title="Permalink to this headline">¶</a></h3>
	  <ul class="simple">
	    <li><a class="reference internal" href="../reference/forms/types/field.html"><em>field</em></a></li>
	    <li><a class="reference internal" href="../reference/forms/types/form.html"><em>form</em></a></li>
	  </ul>
	  <p>Of course, you can also create your own custom field types. This topic is
	    covered in the "<a class="reference internal" href="../cookbook/form/create_custom_field_type.html"><em>How to Create a Custom Form Field Type</em></a>" article
	    of the cookbook.</p>
	</div>
	<div class="section" id="common-field-type-options">
	  <span id="index-4"></span><h3>Common Field Type Options<a class="headerlink" href="#common-field-type-options" title="Permalink to this headline">¶</a></h3>
	  <p>You may have noticed that the <tt class="docutils literal"><span class="pre">price</span></tt> field has been passed an array of
	    options:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'money'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'currency'</span> <span class="o">=&gt;</span> <span class="s1">'USD'</span><span class="p">))</span>
	    </pre></div>
	  </div>
	  <p>Each field type has a number of different options that can be passed to it.
	    Many of these are specific to the field type and details can be found in
	    the documentation for each type. Some options, however, are shared between
	    most fields:</p>
	  <ul>
	    <li><dl class="first docutils">
		<dt><tt class="docutils literal"><span class="pre">required</span></tt> [type: Boolean, default: true]</dt>
		<dd><p class="first last">The <tt class="docutils literal"><span class="pre">required</span></tt> option can be used to render an <a class="reference external" href="http://diveintohtml5.org/forms.html">HTML5 required attribute</a>.
		    Note that this is independent from validation: if you include the required
		    attribute on the field type but omit any required validation, the object
		    will appear to be valid to your application with a blank value. In other
		    words, this is a <em>nice</em> feature that will add client-side validation for
		    browsers that support HTML5. It's not, however, a replacement for true
		    server-side validation.</p>
		</dd>
	      </dl>
	    </li>
	  </ul>
	  <ul>
	    <li><dl class="first docutils">
		<dt><tt class="docutils literal"><span class="pre">max_length</span></tt> [type: integer]</dt>
		<dd><p class="first last">This option is used to add a <tt class="docutils literal"><span class="pre">max_length</span></tt> attribute, which is used by
		    some browsers to limit the amount of text in a field.</p>
		</dd>
	      </dl>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="field-type-guessing">
	<span id="book-forms-field-guessing"></span><span id="index-5"></span><h2>Field Type Guessing<a class="headerlink" href="#field-type-guessing" title="Permalink to this headline">¶</a></h2>
	<p>Now that you've added validation metadata to the <tt class="docutils literal"><span class="pre">Product</span></tt> class, Symfony
	  already knows a bit about your fields. If you allow it, Symfony can "guess"
	  the type of your field and set it up for you. In this example, Symfony will
	  guess from the validation rules that both the <tt class="docutils literal"><span class="pre">name</span></tt> and <tt class="docutils literal"><span class="pre">price</span></tt> fields
	  are normal <tt class="docutils literal"><span class="pre">text</span></tt> fields. Since it's right about the <tt class="docutils literal"><span class="pre">name</span></tt> field, you
	  can modify your code so that Symfony guesses the field for you:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Product</span><span class="p">();</span>

    <span class="nv">$form</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createFormBuilder</span><span class="p">(</span><span class="nv">$product</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'name'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'money'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'currency'</span> <span class="o">=&gt;</span> <span class="s1">'USD'</span><span class="p">))</span>
        <span class="o">-&gt;</span><span class="na">getForm</span><span class="p">();</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">text</span></tt> type for the <tt class="docutils literal"><span class="pre">name</span></tt> field has now been omitted since it's
	  correctly guessed from the validation rules. However, the <tt class="docutils literal"><span class="pre">money</span></tt> type for the
	  <tt class="docutils literal"><span class="pre">price</span></tt> field was kept, since it's more specific than what the system could
	  guess (<tt class="docutils literal"><span class="pre">text</span></tt>).</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p>The <tt class="docutils literal"><span class="pre">createBuilder()</span></tt> method takes up to three arguments (but only
	      the first is required):</p>
	    <blockquote class="last">
	      <div><ul class="simple">
		  <li>the string <tt class="docutils literal"><span class="pre">form</span></tt> stands for the what you're building (a form) and
		    is also used as the name of the form. If you look at the generated
		    code, the two fields are named <tt class="docutils literal"><span class="pre">name="form[price]"</span></tt> and <tt class="docutils literal"><span class="pre">name="form[name]"</span></tt>;</li>
		  <li>The default data to initialize the form fields. This argument can be an
		    associative array or a plain old PHP object like in this example;</li>
		  <li>an array of options for the form.</li>
		</ul>
	    </div></blockquote>
	</div></div>
	<p>This example is pretty trivial, but field guessing can be a major time saver.
	  As you'll see later, adding Doctrine metadata can further improve the system's
	  ability to guess field types.</p>
      </div>
      <div class="section" id="rendering-a-form-in-a-template">
	<span id="form-rendering-template"></span><span id="index-6"></span><h2>Rendering a Form in a Template<a class="headerlink" href="#rendering-a-form-in-a-template" title="Permalink to this headline">¶</a></h2>
	<p>So far, you've seen how an entire form can be rendered with just one line
	  of code. Of course, you'll usually need much more flexibility when rendering:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 274px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/StoreBundle/Resources/views/Default/index.html.twig #}</span>

<span class="nt">&lt;form</span> <span class="na">action=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'store_product'</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span> <span class="na">method=</span><span class="s">"post"</span> <span class="cp">{{</span> <span class="nv">form_enctype</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span><span class="nt">&gt;</span>
    <span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>

    <span class="cp">{{</span> <span class="nv">form_row</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="cp">{{</span> <span class="nv">form_row</span><span class="o">(</span><span class="nv">form.price</span><span class="o">)</span> <span class="cp">}}</span>

    <span class="cp">{{</span> <span class="nv">form_rest</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>

    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"submit"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/form&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="c1">// src/Acme/StoreBundle/Resources/views/Default/index.html.php ?&gt;</span>

<span class="o">&lt;</span><span class="nx">form</span> <span class="nx">action</span><span class="o">=</span><span class="s2">"&lt;?php echo </span><span class="si">$view['router']</span><span class="s2">-&gt;generate('store_product') ?&gt;"</span> <span class="nx">method</span><span class="o">=</span><span class="s2">"post"</span> <span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">enctype</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span>&gt;
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">errors</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span>

    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">row</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">])</span> <span class="cp">?&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">row</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'price'</span><span class="p">])</span> <span class="cp">?&gt;</span>

    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">rest</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span>

    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"submit"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/form&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Let's take a look at each part:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">form_enctype(form)</span></tt> - If at least one field is a file upload field, this
	    renders the obligatory <tt class="docutils literal"><span class="pre">enctype="multipart/form-data"</span></tt>;</li>
	  <li><tt class="docutils literal"><span class="pre">form_errors(form)</span></tt> - Renders any errors global to the whole form
	    (field-specific errors are displayed next to each field);</li>
	  <li><tt class="docutils literal"><span class="pre">form_row(form.price)</span></tt> - Renders the label, any errors, and the HTML
	    form widget for the given field (e.g. <tt class="docutils literal"><span class="pre">price</span></tt>);</li>
	  <li><tt class="docutils literal"><span class="pre">form_rest(form)</span></tt> - Renders any fields that have not yet been rendered.
	    It's usually a good idea to place a call to this helper at the bottom of
	    each form (in case you forgot to output a field or don't want to bother
	    manually rendering hidden fields). This helper is also useful for taking
	    advantage of the automatic <a class="reference internal" href="#forms-csrf"><em>CSRF Protection</em></a>.</li>
	</ul>
	<p>The majority of the work is done by the <tt class="docutils literal"><span class="pre">form_row</span></tt> helper, which renders
	  the label, errors and HTML form widget of each field inside a <tt class="docutils literal"><span class="pre">div</span></tt> tag
	  by default. In the <a class="reference internal" href="#form-theming"><em>Form Theming</em></a> section, you'll learn how
	  the <tt class="docutils literal"><span class="pre">form_row</span></tt> output can be customized on many different levels.</p>
	<div class="section" id="rendering-each-field-by-hand">
	  <h3>Rendering each Field by Hand<a class="headerlink" href="#rendering-each-field-by-hand" title="Permalink to this headline">¶</a></h3>
	  <p>The <tt class="docutils literal"><span class="pre">form_row</span></tt> helper is great because you can very quickly render each
	    field of your form (and the markup used for the "row" can be customized as
	    well). But since life isn't always so simple, you can also render each field
	    entirely by hand:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 328px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>

<span class="nt">&lt;div&gt;</span>
    <span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
<span class="nt">&lt;/div&gt;</span>

<span class="nt">&lt;div&gt;</span>
    <span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form.price</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form.price</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.price</span><span class="o">)</span> <span class="cp">}}</span>
<span class="nt">&lt;/div&gt;</span>

<span class="cp">{{</span> <span class="nv">form_rest</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">errors</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span>

<span class="nt">&lt;div&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">label</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">])</span> <span class="cp">?&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">errors</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">])</span> <span class="cp">?&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">])</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;/div&gt;</span>

<span class="nt">&lt;div&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">label</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'price'</span><span class="p">])</span> <span class="cp">?&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">errors</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'price'</span><span class="p">])</span> <span class="cp">?&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'price'</span><span class="p">])</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;/div&gt;</span>

<span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">rest</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>If the auto-generated label for a field isn't quite right, you can explicitly
	    specify it:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 76px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form.name</span><span class="o">,</span> <span class="s1">'Product name'</span><span class="o">)</span> <span class="cp">}}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">label</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">],</span> <span class="s1">'Product name'</span><span class="p">)</span> <span class="cp">?&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Finally, some field types have additional rendering options that can be passed
	    to the widget. These options are documented with each type, but one common
	    options is <tt class="docutils literal"><span class="pre">attr</span></tt>, which allows you to modify attributes on the form element.
	    The following would add the <tt class="docutils literal"><span class="pre">name_field</span></tt> class to the rendered input text
	    field:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 76px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.name</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'attr'</span><span class="o">:</span> <span class="o">{</span><span class="s1">'class'</span><span class="o">:</span> <span class="s1">'name_field'</span><span class="o">}</span> <span class="o">})</span> <span class="cp">}}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">],</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'attr'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'class'</span> <span class="o">=&gt;</span> <span class="s1">'name_field'</span><span class="p">),</span>
<span class="p">))</span> <span class="cp">?&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
	<div class="section" id="twig-template-function-reference">
	  <h3>Twig Template Function Reference<a class="headerlink" href="#twig-template-function-reference" title="Permalink to this headline">¶</a></h3>
	  <p>If you're using Twig, a full reference of the form rendering functions is
	    available in the <a class="reference internal" href="../reference/forms/twig_reference.html"><em>reference manual</em></a>.</p>
	</div>
      </div>
      <div class="section" id="creating-form-classes">
	<span id="index-7"></span><h2>Creating Form Classes<a class="headerlink" href="#creating-form-classes" title="Permalink to this headline">¶</a></h2>
	<p>As you've seen, a form can be created and used directly in a controller.
	  However, a better practice is to build the form in a separate, standalone PHP
	  class, which can then be reused anywhere in your application. Create a new class
	  that will house the logic for building the product form:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Form/ProductType.php</span>

<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Form</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\Form\AbstractType</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Form\FormBuilder</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">ProductType</span> <span class="k">extends</span> <span class="nx">AbstractType</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">buildForm</span><span class="p">(</span><span class="nx">FormBuilder</span> <span class="nv">$builder</span><span class="p">,</span> <span class="k">array</span> <span class="nv">$options</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'name'</span><span class="p">);</span>
        <span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'money'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'currency'</span> <span class="o">=&gt;</span> <span class="s1">'USD'</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>This new class contains all the directions needed to create the product form.
	  It can be used to quickly build a form object in the controller:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Controller/DefaultController.php</span>

<span class="c1">// add this new use statement at the top of the class</span>
<span class="k">use</span> <span class="nx">Acme\StoreBundle\Form\ProductType</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="c1">// ...</span>
    <span class="nv">$form</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createForm</span><span class="p">(</span><span class="k">new</span> <span class="nx">ProductType</span><span class="p">(),</span> <span class="nv">$product</span><span class="p">);</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p>You can also set the data on the form via the <tt class="docutils literal"><span class="pre">setData()</span></tt> method:</p>
	    <div class="highlight-php"><div class="highlight"><pre><span class="nv">$form</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">createForm</span><span class="p">(</span><span class="k">new</span> <span class="nx">ProductType</span><span class="p">());</span>
<span class="nv">$form</span><span class="o">-&gt;</span><span class="na">setData</span><span class="p">(</span><span class="nv">$product</span><span class="p">);</span>
	      </pre></div>
	    </div>
	    <p>If you use the <tt class="docutils literal"><span class="pre">setData</span></tt> method - and want to take advantage of field
	      type guessing, be sure to add the following to your form class:</p>
	    <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">getDefaultOptions</span><span class="p">(</span><span class="k">array</span> <span class="nv">$options</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'data_class'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\StoreBundle\Entity\Product'</span><span class="p">,</span>
    <span class="p">);</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	    <p class="last">This is necessary because the object is passed to the form after field
	      type guessing.</p>
	</div></div>
	<p>Placing the form logic into its own class means that the form can be easily
	  reused elsewhere in your project. This is the best way to create forms, but
	  the choice is ultimately up to you.</p>
      </div>
      <div class="section" id="forms-and-doctrine">
	<span id="index-8"></span><h2>Forms and Doctrine<a class="headerlink" href="#forms-and-doctrine" title="Permalink to this headline">¶</a></h2>
	<p>The goal of a form is to translate data from an object (e.g. <tt class="docutils literal"><span class="pre">Product</span></tt>) to an
	  HTML form and then translate user-submitted data back to the original object. As
	  such, the topic of persisting the <tt class="docutils literal"><span class="pre">Product</span></tt> object to the database is entirely
	  unrelated to the topic of forms. If you've configured the <tt class="docutils literal"><span class="pre">Product</span></tt> class to
	  be persisted by Doctrine, then persisting it after a form submission can be done
	  when the form is valid:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">if</span> <span class="p">(</span><span class="nv">$form</span><span class="o">-&gt;</span><span class="na">isValid</span><span class="p">())</span> <span class="p">{</span>
    <span class="nv">$em</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getEntityManager</span><span class="p">();</span>
    <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$product</span><span class="p">);</span>
    <span class="nv">$em</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">redirect</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateUrl</span><span class="p">(</span><span class="s1">'store_product_success'</span><span class="p">));</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>If, for some reason, you don't have access to your original <tt class="docutils literal"><span class="pre">$product</span></tt>
	  object, you can fetch it from the form:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$product</span> <span class="o">=</span> <span class="nv">$form</span><span class="o">-&gt;</span><span class="na">getData</span><span class="p">();</span>
	  </pre></div>
	</div>
	<p>For more information, see the <a class="reference internal" href="doctrine.html"><em>Doctrine ORM chapter</em></a>.</p>
	<p>The key thing to understand is that when the form is bound, the submitted
	  data is transferred to the underlying object immediately. If you want to
	  persist that data, you simply need to persist the object itself (which already
	  contains the submitted data).</p>
	<p>If the underlying object of a form (e.g. <tt class="docutils literal"><span class="pre">Product</span></tt>) happens to be mapped
	  with the Doctrine ORM, the form framework will use that information - along
	  with the validation metadata - to guess the type of a particular field.</p>
      </div>
      <div class="section" id="embedded-forms">
	<span id="index-9"></span><h2>Embedded Forms<a class="headerlink" href="#embedded-forms" title="Permalink to this headline">¶</a></h2>
	<p>Often, you'll want to build a form that will include fields from many different
	  objects. For example, a registration form may contain data belonging to
	  a <tt class="docutils literal"><span class="pre">User</span></tt> object as well as many <tt class="docutils literal"><span class="pre">Address</span></tt> objects. Fortunately, this
	  is easy and natural with the form component.</p>
	<div class="section" id="embedding-a-single-object">
	  <h3>Embedding a Single Object<a class="headerlink" href="#embedding-a-single-object" title="Permalink to this headline">¶</a></h3>
	  <p>Suppose that each <tt class="docutils literal"><span class="pre">Product</span></tt> belongs to a simple <tt class="docutils literal"><span class="pre">Category</span></tt> object:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Entity/Category.php</span>
<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Entity</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Category</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">Product</span></tt> class has a new <tt class="docutils literal"><span class="pre">$category</span></tt> property, indicating to which
	    <tt class="docutils literal"><span class="pre">Category</span></tt> it belongs:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Product</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="sd">/**</span>
<span class="sd">     * @Assert\Type(type="Acme\StoreBundle\Entity\Category")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$category</span><span class="p">;</span>

    <span class="c1">// ...</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getCategory</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">category</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setCategory</span><span class="p">(</span><span class="nx">Category</span> <span class="nv">$category</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">category</span> <span class="o">=</span> <span class="nv">$category</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Now that your application has been updated to reflect the new requirements,
	    create a form class so that a <tt class="docutils literal"><span class="pre">Category</span></tt> object can be modified by the user:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/StoreBundle/Form/CategoryType.php</span>
<span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Form</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\Form\AbstractType</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Form\FormBuilder</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">CategoryType</span> <span class="k">extends</span> <span class="nx">AbstractType</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">buildForm</span><span class="p">(</span><span class="nx">FormBuilder</span> <span class="nv">$builder</span><span class="p">,</span> <span class="k">array</span> <span class="nv">$options</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'name'</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getDefaultOptions</span><span class="p">(</span><span class="k">array</span> <span class="nv">$options</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'data_class'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\StoreBundle\Entity\Category'</span><span class="p">,</span>
        <span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The type of the <tt class="docutils literal"><span class="pre">name</span></tt> field is being guessed (as a <tt class="docutils literal"><span class="pre">text</span></tt> field) from
	    the validation metadata of the <tt class="docutils literal"><span class="pre">Category</span></tt> object.</p>
	  <p>The end goal is to allow the <tt class="docutils literal"><span class="pre">Category</span></tt> of a <tt class="docutils literal"><span class="pre">Product</span></tt> to be modified right
	    inside the product form. To accomplish this, add a <tt class="docutils literal"><span class="pre">category</span></tt> field to the
	    <tt class="docutils literal"><span class="pre">ProductType</span></tt> object whose type is an instance of the new <tt class="docutils literal"><span class="pre">CategoryType</span></tt>
	    class:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">buildForm</span><span class="p">(</span><span class="nx">FormBuilder</span> <span class="nv">$builder</span><span class="p">,</span> <span class="k">array</span> <span class="nv">$options</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'category'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">CategoryType</span><span class="p">());</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The fields from <tt class="docutils literal"><span class="pre">CategoryType</span></tt> can now be rendered alongside those from
	    the <tt class="docutils literal"><span class="pre">ProductType</span></tt> class. Render the <tt class="docutils literal"><span class="pre">Category</span></tt> fields in the same way
	    as the original <tt class="docutils literal"><span class="pre">Product</span></tt> fields:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 238px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# ... #}</span>
<span class="cp">{{</span> <span class="nv">form_row</span><span class="o">(</span><span class="nv">form.price</span><span class="o">)</span> <span class="cp">}}</span>

<span class="nt">&lt;h3&gt;</span>Category<span class="nt">&lt;/h3&gt;</span>
<span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"category"</span><span class="nt">&gt;</span>
    <span class="cp">{{</span> <span class="nv">form_row</span><span class="o">(</span><span class="nv">form.category.name</span><span class="o">)</span> <span class="cp">}}</span>
<span class="nt">&lt;/div&gt;</span>

<span class="cp">{{</span> <span class="nv">form_rest</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
<span class="c">{# ... #}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- ... --&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">row</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'price'</span><span class="p">])</span> <span class="cp">?&gt;</span>

<span class="nt">&lt;h3&gt;</span>Category<span class="nt">&lt;/h3&gt;</span>
<span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"category"</span><span class="nt">&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">row</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'category'</span><span class="p">][</span><span class="s1">'name'</span><span class="p">])</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;/div&gt;</span>

<span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">rest</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span>
<span class="c">&lt;!-- ... --&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>When the user submits the form, the submitted data for the <tt class="docutils literal"><span class="pre">Category</span></tt> fields
	    is merged onto the <tt class="docutils literal"><span class="pre">Category</span></tt> object. In other words, everything works
	    exactly as it does with the main <tt class="docutils literal"><span class="pre">Product</span></tt> object. The <tt class="docutils literal"><span class="pre">Category</span></tt> instance
	    is accessible naturally via <tt class="docutils literal"><span class="pre">$product-&gt;getCategory()</span></tt> and can be persisted
	    to the database or used however you need.</p>
	</div>
	<div class="section" id="embedding-a-collection-of-forms">
	  <h3>Embedding a Collection of Forms<a class="headerlink" href="#embedding-a-collection-of-forms" title="Permalink to this headline">¶</a></h3>
	  <p>You can also embed a collection of forms into one form. This is done by
	    using the <tt class="docutils literal"><span class="pre">collection</span></tt> field type. Assuming that you have a property
	    called <tt class="docutils literal"><span class="pre">reviews</span></tt> and a class called <tt class="docutils literal"><span class="pre">ProductReviewType</span></tt>, you could do
	    the following inside <tt class="docutils literal"><span class="pre">ProductType</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">buildForm</span><span class="p">(</span><span class="nx">FormBuilder</span> <span class="nv">$builder</span><span class="p">,</span> <span class="k">array</span> <span class="nv">$options</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'reviews'</span><span class="p">,</span> <span class="s1">'collection'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
       <span class="s1">'type'</span>       <span class="o">=&gt;</span> <span class="k">new</span> <span class="nx">ProductReviewType</span><span class="p">(),</span>
    <span class="p">));</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	</div>
      </div>
      <div class="section" id="form-theming">
	<span id="id1"></span><h2>Form Theming<a class="headerlink" href="#form-theming" title="Permalink to this headline">¶</a></h2>
	<p>Every part of how a form renders can be customized. You're free to change
	  how each form "row" renders, change the markup used to render errors, or
	  even customize how a textarea tag should be rendered. Nothing is off-limits,
	  and different customizations can be used in different places.</p>
	<p>Symfony uses templates to render each and every part of a form. In Twig,
	  the different pieces of a form - a row, a textarea tag, errors - are represented
	  by Twig "blocks". To customize any part of how a form renders, you just need
	  to override the appropriate block.</p>
	<p>To understand how this works, let's customize the <tt class="docutils literal"><span class="pre">form_row</span></tt> output and
	  add a class attribute to the <tt class="docutils literal"><span class="pre">div</span></tt> element that surrounds each row. To
	  do this, create a new template file that will store the new markup:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 274px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/StoreBundle/Resources/views/Form/fields.html.twig #}</span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_row</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">spaceless</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"form_row"</span><span class="nt">&gt;</span>
        <span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
        <span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
        <span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endspaceless</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="nv">field_row</span> <span class="cp">%}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/StoreBundle/Resources/views/Form/field_row.html.php --&gt;</span>
<span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"form_row"</span><span class="nt">&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">label</span><span class="p">(</span><span class="nv">$form</span><span class="p">,</span> <span class="nv">$label</span><span class="p">)</span> <span class="cp">?&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">errors</span><span class="p">(</span><span class="nv">$form</span><span class="p">)</span> <span class="cp">?&gt;</span>
    <span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">,</span> <span class="nv">$parameters</span><span class="p">)</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;/div&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">field_row</span></tt> block is the name of the block used when rendering most
	  fields via the <tt class="docutils literal"><span class="pre">form_row</span></tt> function. To use the <tt class="docutils literal"><span class="pre">field_row</span></tt> block defined
	  in this template, add the following to the top of the template that renders
	  the form:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><pre>{# src/Acme/StoreBundle/Resources/views/Default/index.html.twig #}
{% form_theme form 'AcmeStoreBundle:Form:fields.html.twig' %}

		  &lt;form ...&gt;</pre>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">form_theme</span></tt> tag "imports" the template and uses all of its form-related
	  blocks when rendering the form. In other words, when <tt class="docutils literal"><span class="pre">form_row</span></tt> is called
	  later in this template, it will use the <tt class="docutils literal"><span class="pre">field_row</span></tt> block from the
	  <tt class="docutils literal"><span class="pre">fields.html.twig</span></tt> template.</p>
	<p>To customize any portion of a form, you just need to override the appropriate
	  block. Knowing exactly which block to override is the subject of the next
	  section.</p>
	<p>In the following section, you'll learn more about how to customize different
	  portions of a form. For a more extensive discussion, see <a class="reference internal" href="../cookbook/form/twig_form_customization.html"><em>How to customize Form Rendering in a Twig Template</em></a>.</p>
	<div class="section" id="form-template-blocks">
	  <span id="id2"></span><h3>Form Template Blocks<a class="headerlink" href="#form-template-blocks" title="Permalink to this headline">¶</a></h3>
	  <p>Every part of a form that is rendered - HTML form elements, errors, labels, etc
	    - is defined in a base template as individual Twig blocks. By default, every
	    block needed is defined in the <a class="reference external" href="https://github.com/symfony/symfony/blob/master/src/Symfony/Bundle/TwigBundle/Resources/views/Form/div_layout.html.twig">div_layout.html.twig</a> file that lives inside
	    the core <tt class="docutils literal"><span class="pre">TwigBundle</span></tt>. Inside this file, you can see every block needed
	    to render a form and every default field type.</p>
	  <p>Each block follows the same basic pattern and is broken up into two pieces,
	    separated by a single underscore character (<tt class="docutils literal"><span class="pre">_</span></tt>). A few examples are:</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">field_row</span></tt> - used by <tt class="docutils literal"><span class="pre">form_row</span></tt> to render most fields;</li>
	    <li><tt class="docutils literal"><span class="pre">textarea_widget</span></tt> - used by <tt class="docutils literal"><span class="pre">form_widget</span></tt> to render a <tt class="docutils literal"><span class="pre">textarea</span></tt> field
	      type;</li>
	    <li><tt class="docutils literal"><span class="pre">field_errors</span></tt> - used by <tt class="docutils literal"><span class="pre">form_errors</span></tt> to render errors for a field;</li>
	  </ul>
	  <p>Each block follows the same basic pattern: <tt class="docutils literal"><span class="pre">type_part</span></tt>. The <tt class="docutils literal"><span class="pre">type</span></tt> portion
	    corresponds to the field type being rendered (e.g. <tt class="docutils literal"><span class="pre">textarea</span></tt> or <tt class="docutils literal"><span class="pre">checkbox</span></tt>)
	    whereas the <tt class="docutils literal"><span class="pre">part</span></tt> portion corresponds to <em>what</em> is being rendered (e.g.
	    <tt class="docutils literal"><span class="pre">label</span></tt>, <tt class="docutils literal"><span class="pre">widget</span></tt>). By default, there are exactly 7 possible parts of
	    a form that can be rendered:</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="14%">
	      <col width="28%">
	      <col width="58%">
	    </colgroup>
	    <tbody valign="top">
	      <tr><td><tt class="docutils literal"><span class="pre">label</span></tt></td>
		<td>(e.g. <tt class="docutils literal"><span class="pre">field_label</span></tt>)</td>
		<td>renders the field's label</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">widget</span></tt></td>
		<td>(e.g. <tt class="docutils literal"><span class="pre">field_widget</span></tt>)</td>
		<td>renders the field's HTML representation</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">errors</span></tt></td>
		<td>(e.g. <tt class="docutils literal"><span class="pre">field_errors</span></tt>)</td>
		<td>renders the field's errors</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">row</span></tt></td>
		<td>(e.g. <tt class="docutils literal"><span class="pre">field_row</span></tt>)</td>
		<td>renders the field's entire row (label+widget+errors)</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">rows</span></tt></td>
		<td>(e.g. <tt class="docutils literal"><span class="pre">field_rows</span></tt>)</td>
		<td>renders the child rows of a form</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">rest</span></tt></td>
		<td>(e.g. <tt class="docutils literal"><span class="pre">field_rest</span></tt>)</td>
		<td>renders the unrendered fields of a form</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">enctype</span></tt></td>
		<td>(e.g. <tt class="docutils literal"><span class="pre">field_enctype</span></tt>)</td>
		<td>renders the <tt class="docutils literal"><span class="pre">enctype</span></tt> attribute of a form</td>
	      </tr>
	    </tbody>
	  </table>
	  <p>By knowing the field type (e.g. <tt class="docutils literal"><span class="pre">textarea</span></tt>) and which part you want to
	    customize (e.g. <tt class="docutils literal"><span class="pre">widget</span></tt>), you can construct the block name that needs
	    to be overridden (e.g. <tt class="docutils literal"><span class="pre">textarea_widget</span></tt>). The best way to customize the
	    block is to copy it from <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt> to a new template, customize
	    it, and then use the <tt class="docutils literal"><span class="pre">form_theme</span></tt> tag as shown in the earlier example.</p>
	</div>
	<div class="section" id="form-type-block-inheritance">
	  <h3>Form Type Block Inheritance<a class="headerlink" href="#form-type-block-inheritance" title="Permalink to this headline">¶</a></h3>
	  <p>In some cases, the block you want to customize will appear to be missing.
	    For example, if you look in the <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt> file, you'll find
	    no <tt class="docutils literal"><span class="pre">textarea_errors</span></tt> block. So how are the errors for a textarea field
	    rendered?</p>
	  <p>The answer is: via the <tt class="docutils literal"><span class="pre">field_errors</span></tt> block. When Symfony renders the errors
	    for a textarea type, it looks first for a <tt class="docutils literal"><span class="pre">textarea_errors</span></tt> block before
	    falling back to the <tt class="docutils literal"><span class="pre">field_errors</span></tt> block. Each field type has a <em>parent</em>
	    type (the parent type of <tt class="docutils literal"><span class="pre">textarea</span></tt> is <tt class="docutils literal"><span class="pre">field</span></tt>), and Symfony uses the
	    block for the parent type if the base block doesn't exist.</p>
	  <p>So, to override the errors for <em>only</em> <tt class="docutils literal"><span class="pre">textarea</span></tt> fields, copy the
	    <tt class="docutils literal"><span class="pre">field_errors</span></tt> block, rename it to <tt class="docutils literal"><span class="pre">textarea_errors</span></tt> and customize it. To
	    override the default error rendering for <em>all</em> fields, copy and customize the
	    <tt class="docutils literal"><span class="pre">field_errors</span></tt> block directly.</p>
	</div>
	<div class="section" id="global-form-theming">
	  <h3>Global Form Theming<a class="headerlink" href="#global-form-theming" title="Permalink to this headline">¶</a></h3>
	  <p>So far, you've seen how you can use the <tt class="docutils literal"><span class="pre">form_theme</span></tt> Twig block in a template
	    to import form customizations that will be used inside that template. You can
	    also tell Symfony to automatically use certain form customizations for all
	    templates in your application. To automatically include the customized blocks
	    from the <tt class="docutils literal"><span class="pre">fields.html.twig</span></tt> template created earlier, modify your application
	    configuration file:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">twig</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">form</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">resources</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="s">'AcmeStoreBundle:Form:fields.html.twig'</span><span class="p-Indicator">]</span>
    <span class="c1"># ...</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- app/config/config.xml --&gt;
&lt;twig:config ...&gt;
        &lt;twig:form&gt;
            &lt;resource&gt;AcmeStoreBundle:Form:fields.html.twig&lt;/resource&gt;
        &lt;/twig:form&gt;
        &lt;!-- ... --&gt;
		    &lt;/twig:config&gt;</pre>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'form'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'resources'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'AcmeStoreBundle:Form:fields.html.twig'</span><span class="p">))</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Any blocks inside the <tt class="docutils literal"><span class="pre">fields.html.twig</span></tt> template are now used globally
	    to define form output.</p>
	  <div class="admonition-wrapper">
	    <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Customizing Form Output all in a Single File</p>
	      <p>You can also customize a form block right inside the template where that
		customization is needed. Note that this method will only work if the
		template used extends some base template via the <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">extends</span> <span class="pre">%}</span></tt>:</p>
	      <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'::base.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">form_theme</span> <span class="nv">form</span> <span class="p">_</span><span class="nv">self</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">use</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_row</span> <span class="cp">%}</span>
    <span class="c">{# custom field row output #}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="nv">field_row</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">content</span> <span class="cp">%}</span>
    <span class="c">{# ... #}</span>

    <span class="cp">{{</span> <span class="nv">form_row</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
		</pre></div>
	      </div>
	      <p>The <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">form_theme</span> <span class="pre">form</span> <span class="pre">_self</span> <span class="pre">%}</span></tt> tag allows form blocks to be customized
		directly inside the template that will use those customizations. Use
		this method to quickly make form output customizations that will only
		ever be needed in a single template.</p>
	      <p>The <tt class="docutils literal"><span class="pre">use</span></tt> tag is also helpful as it gives you access to all of the
		blocks defined inside <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt>. For example, this <tt class="docutils literal"><span class="pre">use</span></tt>
		statement is necessary to make the following form customization, as it
		gives you access to the <tt class="docutils literal"><span class="pre">attributes</span></tt> block defined in <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt>:</p>
	      <div class="last highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">text_widget</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"text_widget"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'attributes'</span><span class="o">)</span> <span class="cp">}}</span> <span class="na">value=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">value</span> <span class="cp">}}</span><span class="s">"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
		</pre></div>
	      </div>
	  </div></div>
	</div>
      </div>
      <div class="section" id="csrf-protection">
	<span id="forms-csrf"></span><span id="index-10"></span><h2>CSRF Protection<a class="headerlink" href="#csrf-protection" title="Permalink to this headline">¶</a></h2>
	<p>CSRF - or <a class="reference external" href="http://en.wikipedia.org/wiki/Cross-site_request_forgery">Cross-site request forgery</a> - is a method by which a malicious
	  user attempts to make your legitimate users unknowingly submit data that
	  they don't intend to submit. Fortunately, CSRF attacks can be prevented by
	  using a CSRF token inside your forms.</p>
	<p>The good news is that, by default, Symfony embeds and validates CSRF tokens
	  automatically for you. This means that you can take advantage of the CSRF
	  protection without doing anything. In fact, every form in this chapter has
	  taken advantage of the CSRF protection!</p>
	<p>CSRF protection works by adding a field to your form - called <tt class="docutils literal"><span class="pre">_token</span></tt> by
	  default - that contains a value that only you and your user knows. This ensures
	  that the user - not some other entity - is submitting the given data. Symfony
	  automatically validates the presence and accuracy of this token.</p>
	<p>The <tt class="docutils literal"><span class="pre">_token</span></tt> field is a hidden field and will be automatically rendered
	  if you include the <tt class="docutils literal"><span class="pre">form_rest()</span></tt> function in your template, which ensures
	  that all un-rendered fields are output.</p>
	<p>The CSRF token can be customized on a form-by-form basis. For example:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">ProductType</span> <span class="k">extends</span> <span class="nx">AbstractType</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">getDefaultOptions</span><span class="p">(</span><span class="k">array</span> <span class="nv">$options</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'data_class'</span>      <span class="o">=&gt;</span> <span class="s1">'Acme\StoreBundle\Entity\Product'</span><span class="p">,</span>
            <span class="s1">'csrf_protection'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
            <span class="s1">'csrf_field_name'</span> <span class="o">=&gt;</span> <span class="s1">'_token'</span><span class="p">,</span>
            <span class="s1">'intention'</span>  <span class="o">=&gt;</span> <span class="s1">'product_creation'</span><span class="p">,</span>
        <span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
</pre></div>
</div>
<p>To disable CSRF protection, set the <tt class="docutils literal"><span class="pre">csrf_protection</span></tt> option to false.
Customizations can also be made globally in your project. For more information,
see the <em class="xref std std-ref">form configuration reference</em>
section.</p>
<div class="admonition-wrapper">
<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
<p class="last">The <tt class="docutils literal"><span class="pre">intention</span></tt> option is optional but greatly enhances the security of
the generated token by making it different for each form.</p>
</div></div>
</div>
<div class="section" id="final-thoughts">
<h2>Final Thoughts<a class="headerlink" href="#final-thoughts" title="Permalink to this headline">¶</a></h2>
<p>You now know all of the building blocks necessary to build complex and
functional forms for your application. When building forms, keep in mind that
the first goal of a form is to translate data from an object (<tt class="docutils literal"><span class="pre">Product</span></tt>) to an
HTML form so that the user can modify that data. The second goal of a form is to
take the data submitted by the user and to re-apply it to the object.</p>
<p>There's still much more to learn about the powerful world of forms, such as
how to handle file uploads and how to create a form where a dynamic number
of sub-forms can be added (e.g. a todo list where you can keep adding more
fields via Javascript before submitting). See the cookbook for these topics.</p>
</div>
<div class="section" id="learn-more-from-the-cookbook">
<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
<ul class="simple">
<li><a class="reference internal" href="../cookbook/form/file_uploads.html"><em>Handling File Uploads</em></a></li>
<li><a class="reference internal" href="../cookbook/form/create_custom_field_type.html"><em>Creating Custom Field Types</em></a></li>
<li><a class="reference internal" href="../cookbook/form/twig_form_customization.html"><em>How to customize Form Rendering in a Twig Template</em></a></li>
</ul>
</div>
</div>


        

    </div>

    <div class="navigation">
            <a accesskey="P" title="Validation" href="validation.html">
                «&nbsp;Validation
            </a><span class="separator">|</span>
            <a accesskey="N" title="Security" href="security.html">
                Security&nbsp;»
            </a>
    </div>

    <div class="box_hr"><hr></div>

                                                                            </div>
