<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">


  <div class="box_title">
    <h1 class="title_01">How to customize Form Rendering in a Twig Template</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-customize-form-rendering-in-a-twig-template">
      <h1>How to customize Form Rendering in a Twig Template<a class="headerlink" href="#how-to-customize-form-rendering-in-a-twig-template" title="Permalink to this headline">¶</a></h1>
      <p>If you're using Twig to render your forms, Symfony gives you a wide variety
	of ways to customize their exact output. In this guide, you'll learn how
	to customize every possible part of your form with as little effort as possible.</p>
      <div class="section" id="form-rendering-basics">
	<h2>Form Rendering Basics<a class="headerlink" href="#form-rendering-basics" title="Permalink to this headline">¶</a></h2>
	<p>Recall that the label, error and HTML widget of a form field can easily
	  be rendered by using the <tt class="docutils literal"><span class="pre">form_row</span></tt> Twig function:</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_row</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
	<p>You can also render each of the three parts of the field individually:</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="x">&lt;div&gt;</span>
<span class="x">    </span><span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
<span class="x">    </span><span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
<span class="x">    </span><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
<span class="x">&lt;/div&gt;</span>
	  </pre></div>
	</div>
	<p>In both cases, the form label, errors and HTML widget are rendered by using
	  a set of markup that ships standard with Symfony. For example, both of the
	  above templates would render:</p>
	<div class="highlight-html"><div class="highlight"><pre><span class="nt">&lt;div&gt;</span>
    <span class="nt">&lt;label</span> <span class="na">for=</span><span class="s">"form_name"</span><span class="nt">&gt;</span>Name<span class="nt">&lt;/label&gt;</span>
    <span class="nt">&lt;ul&gt;</span>
        <span class="nt">&lt;li&gt;</span>This field is required<span class="nt">&lt;/li&gt;</span>
    <span class="nt">&lt;/ul&gt;</span>
    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="na">id=</span><span class="s">"form_name"</span> <span class="na">name=</span><span class="s">"form[name]"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/div&gt;</span>
	  </pre></div>
	</div>
	<p>To quickly prototype and test a form, you can render the entire form with
	  just one line:</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
	<p>The remainder of this recipe will explain how every part of the form's markup
	  can be modified at several different levels. For more information about form
	  rendering in general, see <a class="reference internal" href="../../book/forms.html#form-rendering-template"><em>Rendering a Form in a Template</em></a>.</p>
      </div>
      <div class="section" id="what-are-form-themes">
	<h2>What are Form Themes?<a class="headerlink" href="#what-are-form-themes" title="Permalink to this headline">¶</a></h2>
	<p>When any part of a form is rendered - field labels, errors, <tt class="docutils literal"><span class="pre">input</span></tt> text fields,
	  <tt class="docutils literal"><span class="pre">select</span></tt> tags, etc - Symfony uses the markup from a base Twig template file
	  that ships with Symfony. This template, <a class="reference external" href="https://github.com/symfony/symfony/blob/master/src/Symfony/Bundle/TwigBundle/Resources/views/Form/div_layout.html.twig">div_layout.html.twig</a>, contains
	  Twig blocks that define each and every part of a form that can be rendered.
	  This template represents the default form "theme" and in the next section,
	  you'll learn how to import your own set of customized form blocks (i.e. themes).</p>
	<p>For example, when the widget of a <tt class="docutils literal"><span class="pre">text</span></tt> type field is rendered, an <tt class="docutils literal"><span class="pre">input</span></tt>
	  <tt class="docutils literal"><span class="pre">text</span></tt> field is generated</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>

<span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="na">id=</span><span class="s">"form_name"</span> <span class="na">name=</span><span class="s">"form[name]"</span> <span class="na">required=</span><span class="s">"required"</span> <span class="na">value=</span><span class="s">"foo"</span> <span class="nt">/&gt;</span>
	  </pre></div>
	</div>
	<p>Internally, Symfony uses the <tt class="docutils literal"><span class="pre">text_widget</span></tt> block from the <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt>
	  template to render the field. This is because the field type is <tt class="docutils literal"><span class="pre">text</span></tt> and
	  you're rendering its <tt class="docutils literal"><span class="pre">widget</span></tt> (as opposed to its <tt class="docutils literal"><span class="pre">label</span></tt> or <tt class="docutils literal"><span class="pre">errors</span></tt>).
	  The default implementation of the <tt class="docutils literal"><span class="pre">text_widget</span></tt> block looks like this:</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">text_widget</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    </span><span class="cp">{%</span> <span class="k">set</span> <span class="nv">type</span> <span class="o">=</span> <span class="nv">type</span><span class="o">|</span><span class="nf">default</span><span class="o">(</span><span class="s1">'text'</span><span class="o">)</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    </span><span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'field_widget'</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="nv">text_widget</span> <span class="cp">%}</span><span class="x"></span>
	  </pre></div>
	</div>
	<p>As you can see, this block itself renders another block - <tt class="docutils literal"><span class="pre">field_widget</span></tt>
	  that lives in <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt>:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_widget</span> <span class="cp">%}</span>
    <span class="cp">{%</span> <span class="k">set</span> <span class="nv">type</span> <span class="o">=</span> <span class="nv">type</span><span class="o">|</span><span class="nf">default</span><span class="o">(</span><span class="s1">'text'</span><span class="o">)</span> <span class="cp">%}</span>
    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">type</span> <span class="cp">}}</span><span class="s">"</span> <span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'attributes'</span><span class="o">)</span> <span class="cp">}}</span> <span class="na">value=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">value</span> <span class="cp">}}</span><span class="s">"</span> <span class="nt">/&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="nv">field_widget</span> <span class="cp">%}</span>
	  </pre></div>
	</div>
	<p>The point is, the blocks inside <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt> dictate the HTML
	  output of each part of a form. To customize form output, you just need to
	  identify and override the correct block. When any number of these form block
	  customizations are put into a template, that template is known as a from "theme".
	  When rendering a form, you can choose which form theme(s) you want to apply.</p>
	<div class="admonition-wrapper" id="cookbook-form-twig-customization-sidebar">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Knowing which block to customize</p>
	    <p>In this example, the customized block name is <tt class="docutils literal"><span class="pre">text_widget</span></tt> because you
	      want to override the HTML <tt class="docutils literal"><span class="pre">widget</span></tt> for all <tt class="docutils literal"><span class="pre">text</span></tt> field types. If you
	      need to customize textarea fields, you would customize <tt class="docutils literal"><span class="pre">textarea_widget</span></tt>.</p>
	    <p>As you can see, the block name is a combination of the field type and
	      which part of the field is being rendered (e.g. <tt class="docutils literal"><span class="pre">widget</span></tt>, <tt class="docutils literal"><span class="pre">label</span></tt>,
	      <tt class="docutils literal"><span class="pre">errors</span></tt>, <tt class="docutils literal"><span class="pre">row</span></tt>). As such, to customize how errors are rendered for
	      just input <tt class="docutils literal"><span class="pre">text</span></tt> fields, you should customize the <tt class="docutils literal"><span class="pre">text_errors</span></tt> block.</p>
	    <p>More commonly, however, you'll want to customize how errors are displayed
	      across <em>all</em> fields. You can do this by customizing the <tt class="docutils literal"><span class="pre">field_errors</span></tt>
	      block. This takes advantage of field type inheritance. Specifically,
	      since the <tt class="docutils literal"><span class="pre">text</span></tt> type extends from the <tt class="docutils literal"><span class="pre">field</span></tt> type, the form component
	      will first look for the type-specific block (e.g. <tt class="docutils literal"><span class="pre">text_errors</span></tt>) before
	      falling back to its parent block name if it doesn't exist (e.g. <tt class="docutils literal"><span class="pre">field_errors</span></tt>).</p>
	    <p class="last">For more information on this topic, see <a class="reference internal" href="../../book/forms.html#form-template-blocks"><em>Form Template Blocks</em></a>.</p>
	</div></div>
      </div>
      <div class="section" id="form-theming-the-2-methods">
	<span id="cookbook-form-twig-two-methods"></span><h2>Form Theming: The 2 Methods<a class="headerlink" href="#form-theming-the-2-methods" title="Permalink to this headline">¶</a></h2>
	<p>To see the power of form theming, suppose you want to wrap every input <tt class="docutils literal"><span class="pre">text</span></tt>
	  field with a <tt class="docutils literal"><span class="pre">div</span></tt> tag. The key to doing this is to customize the <tt class="docutils literal"><span class="pre">text_widget</span></tt>
	  block.</p>
	<p>When customizing the form field block, you have two options on <em>where</em> the
	  customized form block can live:</p>
	<table border="1" class="docutils">
	  <colgroup>
	    <col width="33%">
	    <col width="30%">
	    <col width="37%">
	  </colgroup>
	  <thead valign="bottom">
	    <tr><th class="head">Method</th>
	      <th class="head">Pros</th>
	      <th class="head">Cons</th>
	    </tr>
	  </thead>
	  <tbody valign="top">
	    <tr><td>Inside the same template as the form</td>
	      <td>Quick and easy</td>
	      <td>Can't be reused in other templates</td>
	    </tr>
	    <tr><td>Inside a separate template</td>
	      <td>Can be reused by many templates</td>
	      <td>Requires an extra template to be created</td>
	    </tr>
	  </tbody>
	</table>
	<p>Both methods have the same effect but are better in different situations.
	  In the next section, you'll learn how to make the same form customization
	  using both methods.</p>
	<div class="section" id="method-1-inside-the-same-template-as-the-form">
	  <span id="cookbook-form-theming-self"></span><h3>Method 1: Inside the same Template as the Form<a class="headerlink" href="#method-1-inside-the-same-template-as-the-form" title="Permalink to this headline">¶</a></h3>
	  <p>The easiest way to customize the <tt class="docutils literal"><span class="pre">text_widget</span></tt> block is to customize it
	    directly in the template that's actually rendering the form.</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'::base.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">form_theme</span> <span class="nv">form</span> <span class="p">_</span><span class="nv">self</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">use</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">text_widget</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"text_widget"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'attributes'</span><span class="o">)</span> <span class="cp">}}</span> <span class="na">value=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">value</span> <span class="cp">}}</span><span class="s">"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">content</span> <span class="cp">%}</span>
    <span class="c">{# render the form #}</span>

    <span class="cp">{{</span> <span class="nv">form_row</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
	      <p class="last">Note that this <strong>only</strong> works if your template extends a base template
		via the <tt class="docutils literal"><span class="pre">extends</span></tt> tag. If your template doesn't extend a base template,
		you should put your customized blocks in a separate template (see
		<a class="reference internal" href="#cookbook-form-twig-separate-template"><em>Method 2: Inside a Separate Template</em></a>).</p>
	  </div></div>
	  <p>By using the special <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">form_theme</span> <span class="pre">form</span> <span class="pre">_self</span> <span class="pre">%}</span></tt> tag, Twig looks inside
	    the same template for any overridden form blocks. Assuming the <tt class="docutils literal"><span class="pre">form.name</span></tt>
	    field is a <tt class="docutils literal"><span class="pre">text</span></tt> type field, when its widget is rendered, the customized
	    <tt class="docutils literal"><span class="pre">text_widget</span></tt> block will be used.</p>
	  <p>The disadvantage of this method is that the customized form block can't be
	    reused when rendering other forms in other templates. In other words, this method
	    is most useful when making form customizations that are specific to a single
	    form in your application. If you want to reuse a form customization across
	    several (or all) forms in your application, read on to the next section.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p>Be sure also to include the <tt class="docutils literal"><span class="pre">use</span></tt> statement somewhere in your template
		when using this method:</p>
	      <div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">use</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="cp">%}</span><span class="x"></span>
		</pre></div>
	      </div>
	      <p class="last">This "imports" all of the blocks from the base <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt>
		template, which gives you access to the <tt class="docutils literal"><span class="pre">attributes</span></tt> block. In general,
		the <tt class="docutils literal"><span class="pre">use</span></tt> tag is helpful when your template <em>already</em> extends a base
		template, but you still need to import blocks from a second template.
		Read more about <a class="reference external" href="http://www.twig-project.org/doc/templates.html#horizontal-reuse">Horizontal Reuse</a> in the Twig documentation.</p>
	  </div></div>
	</div>
	<div class="section" id="method-2-inside-a-separate-template">
	  <span id="cookbook-form-twig-separate-template"></span><h3>Method 2: Inside a Separate Template<a class="headerlink" href="#method-2-inside-a-separate-template" title="Permalink to this headline">¶</a></h3>
	  <p>You can also choose to put the customized <tt class="docutils literal"><span class="pre">text_widget</span></tt> form block in a
	    separate template entirely. The code and end-result are the same, but you
	    can now re-use the form customization across many templates:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="c">{# src/Acme/DemoBundle/Resources/views/Form/fields.html.twig #}</span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">text_widget</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"text_widget"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'attributes'</span><span class="o">)</span> <span class="cp">}}</span> <span class="na">value=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">value</span> <span class="cp">}}</span><span class="s">"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">The template extends the base template (<tt class="docutils literal"><span class="pre">TwigBundle:Form:div_layout.html.twig</span></tt>)
		so that you have access to the <tt class="docutils literal"><span class="pre">field_widget</span></tt> block defined there. If
		you forget the <tt class="docutils literal"><span class="pre">extends</span></tt> tag, the HTML input element will be missing
		several HTML attributes (since the <tt class="docutils literal"><span class="pre">attributes</span></tt> block isn't defined).</p>
	  </div></div>
	  <p>Now that you've created the customized form block, you need to tell Symfony
	    to use it. Inside the template where you're actually rendering your form,
	    tell Symfony to use the template via the <tt class="docutils literal"><span class="pre">form_theme</span></tt> tag:</p>
	  <div class="highlight-html+jinja" id="cookbook-form-theme-import-template"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">form_theme</span> <span class="nv">form</span> <span class="s1">'AcmeDemoBundle:Form:fields.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
	    </pre></div>
	  </div>
	  <p>When the <tt class="docutils literal"><span class="pre">form.name</span></tt> widget is rendered, Symfony will use the <tt class="docutils literal"><span class="pre">text_widget</span></tt>
	    block from the new template and the <tt class="docutils literal"><span class="pre">input</span></tt> tag will be wrapped in the
	    <tt class="docutils literal"><span class="pre">div</span></tt> element specified in the customized block.</p>
	</div>
      </div>
      <div class="section" id="referencing-base-form-blocks">
	<span id="cookbook-form-twig-import-base-blocks"></span><h2>Referencing Base Form Blocks<a class="headerlink" href="#referencing-base-form-blocks" title="Permalink to this headline">¶</a></h2>
	<p>So far, to override a particular form block, the best method is to copy
	  the default block from <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt>, paste it into a different template,
	  and the customize it. In many cases, you can avoid doing this by referencing
	  the base block when customizing it.</p>
	<p>This is easy to do, but varies slightly depending on if your form block customizations
	  are in the same template as the form or a separate template.</p>
	<div class="section" id="referencing-blocks-from-inside-the-same-template-as-the-form">
	  <h3>Referencing Blocks from inside the same Template as the Form<a class="headerlink" href="#referencing-blocks-from-inside-the-same-template-as-the-form" title="Permalink to this headline">¶</a></h3>
	  <p>Start by modifying the <tt class="docutils literal"><span class="pre">use</span></tt> tag in the template where you're rendering
	    the form:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">use</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="k">with</span> <span class="nv">text_widget</span> <span class="k">as</span> <span class="nv">base_text_widget</span> <span class="cp">%}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <p>Now, when the blocks from <tt class="docutils literal"><span class="pre">div_layout.html.twig</span></tt> are imported, the <tt class="docutils literal"><span class="pre">text_widget</span></tt>
	    block is called <tt class="docutils literal"><span class="pre">base_text_widget</span></tt>. This means that when you redefine the
	    <tt class="docutils literal"><span class="pre">text_widget</span></tt> block, you can reference the default markup via <tt class="docutils literal"><span class="pre">base_text_widget</span></tt>:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">text_widget</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"text_widget"</span><span class="nt">&gt;</span>
        <span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'base_text_widget'</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="referencing-base-blocks-from-an-external-template">
	  <h3>Referencing Base Blocks from an External Template<a class="headerlink" href="#referencing-base-blocks-from-an-external-template" title="Permalink to this headline">¶</a></h3>
	  <p>If your form customizations live inside an external template, you can reference
	    the base block by using the <tt class="docutils literal"><span class="pre">parent()</span></tt> Twig function:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="c">{# src/Acme/DemoBundle/Resources/views/Form/fields.html.twig #}</span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">text_widget</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"text_widget"</span><span class="nt">&gt;</span>
        <span class="cp">{{</span> <span class="nv">parent</span><span class="o">()</span> <span class="cp">}}</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="nv">text_widget</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	</div>
      </div>
      <div class="section" id="making-application-wide-customizations">
	<span id="cookbook-form-global-theming"></span><h2>Making Application-wide Customizations<a class="headerlink" href="#making-application-wide-customizations" title="Permalink to this headline">¶</a></h2>
	<p>If you'd like a certain form customization to be global to your application,
	  you can accomplish this by making the form customizations to an external
	  template and then importing it inside your application configuration:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">twig</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">form</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">resources</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="s">'AcmeDemoBundle:Form:fields.html.twig'</span><span class="p-Indicator">]</span>
    <span class="c1"># ...</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- app/config/config.xml --&gt;
&lt;twig:config ...&gt;
    &lt;twig:form&gt;
        &lt;twig:resource&gt;AcmeDemoBundle:Form:fields.html.twig&lt;/twig:resource&gt;
    &lt;/twig:form&gt;
    &lt;!-- ... --&gt;
		  &lt;/twig:config&gt;</pre>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'form'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'resources'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'AcmeDemoBundle:Form:fields.html.twig'</span><span class="p">))</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Any customized form blocks inside the <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Form:fields.html.twig</span></tt>
	  template will be used globally when form elements are rendered.</p>
	<p>By default, twig uses a <em>div</em> layout when rendering forms. Some people, however,
	  may prefer to render forms in a <em>table</em> layout. The technique to change to
	  the table layout is the same as shown above, except you will need to change:</p>
	<p><tt class="docutils literal"><span class="pre">AcmeDemoBundle:Form:fields.html.twig</span></tt> to <tt class="docutils literal"><span class="pre">TwigBundle:Form:table_layout.html.twig</span></tt></p>
	<p>If you only want to make the change in one template, do the following:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">form_theme</span> <span class="nv">form</span> <span class="s1">'TwigBundle:Form:table_layout.html.twig'</span> <span class="cp">%}</span>
	  </pre></div>
	</div>
	<p>Note that the <tt class="docutils literal"><span class="pre">form</span></tt> variable in the above code is the form view variable
	  that you passed to your template.</p>
      </div>
      <div class="section" id="how-to-customize-an-individual-field">
	<h2>How to customize an Individual field<a class="headerlink" href="#how-to-customize-an-individual-field" title="Permalink to this headline">¶</a></h2>
	<p>So far, you've seen the different ways you can customize the widget output
	  of all text field types. You can also customize individual fields. For example,
	  suppose you have two <tt class="docutils literal"><span class="pre">text</span></tt> fields - <tt class="docutils literal"><span class="pre">first_name</span></tt> and <tt class="docutils literal"><span class="pre">last_name</span></tt> - but
	  you only want to customize one of the fields. This can be accomplished by
	  customizing a block whose name is a combination of the field name and which
	  part of the field is being customized. For example:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">form_theme</span> <span class="nv">form</span> <span class="p">_</span><span class="nv">self</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">use</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="p">_</span><span class="nv">product_name_widget</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"text_widget"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'attributes'</span><span class="o">)</span> <span class="cp">}}</span> <span class="na">value=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">value</span> <span class="cp">}}</span><span class="s">"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>

<span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
	  </pre></div>
	</div>
	<p>Here, the <tt class="docutils literal"><span class="pre">_product_name_widget</span></tt> defines the template to use for the field
	  whose <em>id</em> is <tt class="docutils literal"><span class="pre">product_name</span></tt> (name <tt class="docutils literal"><span class="pre">product[name]</span></tt>).</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">The <tt class="docutils literal"><span class="pre">product</span></tt> portion of the field is the form name, which may be set
	      manually or generated automatically based on your form type name (e.g.
	      <tt class="docutils literal"><span class="pre">ProductType</span></tt> equates to <tt class="docutils literal"><span class="pre">product</span></tt>). If you're not sure what your
	      form name is, just view the source of your generated form.</p>
	</div></div>
	<p>You can also override the markup for an entire field row using the same method:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">form_theme</span> <span class="nv">form</span> <span class="p">_</span><span class="nv">self</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">use</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="p">_</span><span class="nv">product_name_row</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"name_row"</span><span class="nt">&gt;</span>
        <span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
        <span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
        <span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>

<span class="cp">{{</span> <span class="nv">form_row</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="other-common-customizations">
	<h2>Other Common Customizations<a class="headerlink" href="#other-common-customizations" title="Permalink to this headline">¶</a></h2>
	<p>So far, this recipe has shown you several different ways to customize a single
	  piece of how a form is rendered. The key is to customize a specific Twig
	  block that corresponds to the portion of the form you want to control (see
	  <a class="reference internal" href="#cookbook-form-twig-customization-sidebar"><em>naming form blocks</em></a>).</p>
	<p>In the next sections, you'll see how you can make several common form customizations.
	  To apply these customizations, use one of the two methods described in the
	  <a class="reference internal" href="#cookbook-form-twig-two-methods"><em>Form Theming: The 2 Methods</em></a> section.</p>
	<div class="section" id="customizing-error-output">
	  <h3>Customizing Error Output<a class="headerlink" href="#customizing-error-output" title="Permalink to this headline">¶</a></h3>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">The form component only handles <em>how</em> the validation errors are rendered,
		and not the actual validation error messages. The error messages themselves
		are determined by the validation constraints you apply to your objects.
		For more information, see the chapter on <a class="reference internal" href="../../book/validation.html"><em>validation</em></a>.</p>
	  </div></div>
	  <p>There are many different ways to customize how errors are rendered when a
	    form is submitted with errors. The error messages for a field are rendered
	    when you use the <tt class="docutils literal"><span class="pre">form_errors</span></tt> helper:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form.name</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <p>By default, the errors are rendered inside an unordered list:</p>
	  <div class="highlight-html"><div class="highlight"><pre><span class="nt">&lt;ul&gt;</span>
    <span class="nt">&lt;li&gt;</span>This field is required<span class="nt">&lt;/li&gt;</span>
<span class="nt">&lt;/ul&gt;</span>
	    </pre></div>
	  </div>
	  <p>To override how errors are rendered for <em>all</em> fields, simply copy, paste
	    and customize the <tt class="docutils literal"><span class="pre">field_errors</span></tt> block:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_errors</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">spaceless</span> <span class="cp">%}</span>
    <span class="cp">{%</span> <span class="k">if</span> <span class="nv">errors</span><span class="o">|</span><span class="nf">length</span> <span class="o">&gt;</span> <span class="m">0</span> <span class="cp">%}</span>
    <span class="nt">&lt;ul</span> <span class="na">class=</span><span class="s">"error_list"</span><span class="nt">&gt;</span>
        <span class="cp">{%</span> <span class="k">for</span> <span class="nv">error</span> <span class="k">in</span> <span class="nv">errors</span> <span class="cp">%}</span>
            <span class="nt">&lt;li&gt;</span><span class="cp">{{</span> <span class="nv">error.messageTemplate</span><span class="o">|</span><span class="nf">trans</span><span class="o">(</span><span class="nv">error.messageParameters</span><span class="o">,</span> <span class="s1">'validators'</span><span class="o">)</span> <span class="cp">}}</span><span class="nt">&lt;/li&gt;</span>
        <span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
    <span class="nt">&lt;/ul&gt;</span>
    <span class="cp">{%</span> <span class="k">endif</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endspaceless</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="nv">field_errors</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">See <a class="reference internal" href="#cookbook-form-twig-two-methods"><em>Form Theming: The 2 Methods</em></a> for how to apply this customization.</p>
	  </div></div>
	  <p>You can also customize the error output for just one specific field type.
	    For example, certain errors that are more global to your form (i.e. not specific
	    to just one field) are rendered separately, usually at the top of your form:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <p>To customize <em>only</em> the markup used for these errors, follow the same directions
	    as above, but now call the block <tt class="docutils literal"><span class="pre">form_errors</span></tt>. Now, when errors for the
	    <tt class="docutils literal"><span class="pre">form</span></tt> type are rendered, the <tt class="docutils literal"><span class="pre">form_errors</span></tt> block will be used instead
	    of the default <tt class="docutils literal"><span class="pre">field_errors</span></tt> block.</p>
	</div>
	<div class="section" id="customizing-the-form-row">
	  <h3>Customizing the "Form Row"<a class="headerlink" href="#customizing-the-form-row" title="Permalink to this headline">¶</a></h3>
	  <p>When you can manage it, the easiest way to render a form field is via the
	    <tt class="docutils literal"><span class="pre">form_row</span></tt> function, which renders the label, errors and HTML widget of
	    a field. To customize the markup used for rendering <em>all</em> form field rows,
	    override the <tt class="docutils literal"><span class="pre">field_row</span></tt> block. For example, suppose you want to add a
	    class to the <tt class="docutils literal"><span class="pre">div</span></tt> element around each row:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_row</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"form_row"</span><span class="nt">&gt;</span>
        <span class="cp">{{</span> <span class="nv">form_label</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
        <span class="cp">{{</span> <span class="nv">form_errors</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
        <span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="nv">field_row</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">See <a class="reference internal" href="#cookbook-form-twig-two-methods"><em>Form Theming: The 2 Methods</em></a> for how to apply this customization.</p>
	  </div></div>
	</div>
	<div class="section" id="adding-a-required-asterisk-to-field-labels">
	  <h3>Adding a "Required" Asterisk to Field Labels<a class="headerlink" href="#adding-a-required-asterisk-to-field-labels" title="Permalink to this headline">¶</a></h3>
	  <p>If you want to denote all of your required fields with a required asterisk (<tt class="docutils literal"><span class="pre">*</span></tt>),
	    you can do this by customizing the <tt class="docutils literal"><span class="pre">field_label</span></tt> block.</p>
	  <p>If you're making the form customization inside the same template as your
	    form, modify the <tt class="docutils literal"><span class="pre">use</span></tt> tag and add the following:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">use</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="k">with</span> <span class="nv">field_label</span> <span class="k">as</span> <span class="nv">base_field_label</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_label</span> <span class="cp">%}</span>
    <span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'base_field_label'</span><span class="o">)</span> <span class="cp">}}</span>

    <span class="cp">{%</span> <span class="k">if</span> <span class="nv">required</span> <span class="cp">%}</span>
        <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"required"</span> <span class="na">title=</span><span class="s">"This field is required"</span><span class="nt">&gt;</span>*<span class="nt">&lt;/span&gt;</span>
    <span class="cp">{%</span> <span class="k">endif</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	  <p>If you're making the form customization inside a separate template, use the
	    following:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_label</span> <span class="cp">%}</span>
    <span class="cp">{{</span> <span class="nv">parent</span><span class="o">()</span> <span class="cp">}}</span>

    <span class="cp">{%</span> <span class="k">if</span> <span class="nv">required</span> <span class="cp">%}</span>
        <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"required"</span> <span class="na">title=</span><span class="s">"This field is required"</span><span class="nt">&gt;</span>*<span class="nt">&lt;/span&gt;</span>
    <span class="cp">{%</span> <span class="k">endif</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">See <a class="reference internal" href="#cookbook-form-twig-two-methods"><em>Form Theming: The 2 Methods</em></a> for how to apply this customization.</p>
	  </div></div>
	</div>
	<div class="section" id="adding-help-messages">
	  <h3>Adding "help" messages<a class="headerlink" href="#adding-help-messages" title="Permalink to this headline">¶</a></h3>
	  <p>You can also customize your form widgets to have an optional "help" message.</p>
	  <p>If you're making the form customization inside the same template as your
	    form, modify the <tt class="docutils literal"><span class="pre">use</span></tt> tag and add the following:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">use</span> <span class="s1">'TwigBundle:Form:div_layout.html.twig'</span> <span class="k">with</span> <span class="nv">field_widget</span> <span class="k">as</span> <span class="nv">base_field_widget</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_widget</span> <span class="cp">%}</span>
    <span class="cp">{{</span> <span class="nb">block</span><span class="o">(</span><span class="s1">'base_field_widget'</span><span class="o">)</span> <span class="cp">}}</span>

    <span class="cp">{%</span> <span class="k">if</span> <span class="nv">help</span> <span class="k">is</span> <span class="nf">defined</span> <span class="cp">%}</span>
        <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"help"</span><span class="nt">&gt;</span><span class="cp">{{</span> <span class="nv">help</span> <span class="cp">}}</span><span class="nt">&lt;/div&gt;</span>
    <span class="cp">{%</span> <span class="k">endif</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	  <p>If you're making the form customization inside a separate template, use the
	    following:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">block</span> <span class="nv">field_widget</span> <span class="cp">%}</span>
    <span class="cp">{{</span> <span class="nv">parent</span><span class="o">()</span> <span class="cp">}}</span>

    <span class="cp">{%</span> <span class="k">if</span> <span class="nv">help</span> <span class="k">is</span> <span class="nf">defined</span> <span class="cp">%}</span>
        <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"help"</span><span class="nt">&gt;</span><span class="cp">{{</span> <span class="nv">help</span> <span class="cp">}}</span><span class="nt">&lt;/div&gt;</span>
    <span class="cp">{%</span> <span class="k">endif</span> <span class="cp">%}</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	    </pre></div>
	  </div>
	  <p>To render a help message below a field, pass in a <tt class="docutils literal"><span class="pre">help</span></tt> variable:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.title</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'help'</span><span class="o">:</span> <span class="s1">'foobar'</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">See <a class="reference internal" href="#cookbook-form-twig-two-methods"><em>Form Theming: The 2 Methods</em></a> for how to apply this customization.</p>
	  </div></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Registering Custom DQL Functions" href="../doctrine/custom_dql_functions.html">
      «&nbsp;Registering Custom DQL Functions
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to Create a Custom Form Field Type" href="create_custom_field_type.html">
      How to Create a Custom Form Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
