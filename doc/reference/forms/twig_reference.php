<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Twig Template Form Function Reference</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="twig-template-form-function-reference">
      <h1>Twig Template Form Function Reference<a class="headerlink" href="#twig-template-form-function-reference" title="Permalink to this headline">¶</a></h1>
      <p>This reference manual covers all the possible Twig functions available for
	rendering forms. There are several different functions available, and each
	is responsible for rendering a different part of a form (e.g. labels, errors,
	widgets, etc).</p>
      <div class="section" id="form-label-form-name-label-variables">
	<h2>form_label(form.name, label, variables)<a class="headerlink" href="#form-label-form-name-label-variables" title="Permalink to this headline">¶</a></h2>
	<p>Renders the label for the given field. You can optionally pass the specific
	  label you want to display as the second argument.</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>

<span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form.name</span><span class="o">,</span> <span class="s1">'Your Name'</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'attr'</span><span class="o">:</span> <span class="o">{</span><span class="s1">'class'</span><span class="o">:</span> <span class="s1">'foo'</span><span class="o">}</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="form-errors-form-name">
	<h2>form_errors(form.name)<a class="headerlink" href="#form-errors-form-name" title="Permalink to this headline">¶</a></h2>
	<p>Renders any errors for the given field.</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>

<span class="c">{# render any "global" errors #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="form-widget-form-name-variables">
	<h2>form_widget(form.name, variables)<a class="headerlink" href="#form-widget-form-name-variables" title="Permalink to this headline">¶</a></h2>
	<p>Renders the HTML widget of a given field. If you apply this to an entire form
	  or collection of fields, each underlying form row will be rendered.</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="c">{# render a widget, but add a "foo" class to it #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.name</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'attr'</span><span class="o">:</span> <span class="o">{</span><span class="s1">'class'</span><span class="o">:</span> <span class="s1">'foo'</span><span class="o">}</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
	<p>The second argument to <tt class="docutils literal"><span class="pre">form_widget</span></tt> is an array of variables. The most
	  common variable is <tt class="docutils literal"><span class="pre">attr</span></tt>, which is an array of HTML attributes to apply
	  to the HTML widget. In some cases, certain types also have other template-related
	  options that can be passed. These are discussed on a type-by-type basis.</p>
      </div>
      <div class="section" id="form-row-form-name-variables">
	<h2>form_row(form.name, variables)<a class="headerlink" href="#form-row-form-name-variables" title="Permalink to this headline">¶</a></h2>
	<p>Renders the "row" of a given field, which is the combination of the field's
	  label, errors and widget.</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="c">{# render a field row, but add a "foo" class to it #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.name</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'attr'</span><span class="o">:</span> <span class="o">{</span><span class="s1">'class'</span><span class="o">:</span> <span class="s1">'foo'</span><span class="o">}</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
	<p>The second argument to <tt class="docutils literal"><span class="pre">form_row</span></tt> is an array of variables. The most
	  common variable is <tt class="docutils literal"><span class="pre">attr</span></tt>, which is an array of HTML attributes to apply
	  to the HTML widget inside the row. In some cases, certain types also have
	  other template-related options that can be passed. These are discussed on
	  a type-by-type basis.</p>
      </div>
      <div class="section" id="form-rest-form-variables">
	<h2>form_rest(form, variables)<a class="headerlink" href="#form-rest-form-variables" title="Permalink to this headline">¶</a></h2>
	<p>This renders all fields that have not yet been rendered for the given form.
	  It's a good idea to always have this somewhere inside your form as it'll
	  render hidden fields for you and make any fields you forgot to render more
	  obvious (since it'll render the field for you).</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_rest</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="form-enctype-form">
	<h2>form_enctype(form)<a class="headerlink" href="#form-enctype-form" title="Permalink to this headline">¶</a></h2>
	<p>If the form contains at least one file upload field, this will render the
	  required <tt class="docutils literal"><span class="pre">enctype="multipart/form-data"</span></tt> form attribute. It's always a
	  good idea to include this in your form tag:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="nt">&lt;form</span> <span class="na">action=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'form_submit'</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span> <span class="na">method=</span><span class="s">"post"</span> <span class="cp">{{</span> <span class="nv">form_enctype</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span><span class="nt">&gt;</span>
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="url Field Type" href="types/url.html">
      «&nbsp;url Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="Validation Constraints Reference" href="../constraints.html">
      Validation Constraints Reference&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
