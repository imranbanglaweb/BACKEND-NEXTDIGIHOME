<template id="premiumProductDescriptionTemplate">
<section class="product-template">
    <h2>__PRODUCT_NAME__</h2>
    <p><strong>__PRODUCT_NAME__</strong> is a premium __CATEGORY__ product built to help customers move faster with a polished, ready-to-use digital asset.</p>

    <h3>What You Get</h3>
    <ul>
        <li>Complete product files or access details after purchase</li>
        <li>Clear setup, usage, or implementation guidance</li>
        <li>Reusable assets designed for real business and creative workflows</li>
        <li>Future-friendly structure that works for eBooks, SaaS tools, source code, templates, prompts, and digital kits</li>
    </ul>

    <h3>Key Benefits</h3>
    <ul>
        <li>Save time with a finished product foundation</li>
        <li>Reduce trial-and-error with organized resources</li>
        <li>Customize the product for your own brand, workflow, or project</li>
        <li>Use it for learning, launching, automation, client work, or internal operations</li>
    </ul>

    <h3>Best For</h3>
    <ul>
        <li>Founders and business owners</li>
        <li>Developers, designers, marketers, and creators</li>
        <li>Agencies and freelancers delivering client projects</li>
        <li>Teams that need practical digital resources without starting from scratch</li>
    </ul>

    <h3>Included Format</h3>
    <p>__DELIVERY_TYPE__. Delivery details, files, access links, or instructions are provided according to the product setup.</p>

    <h3>How To Use</h3>
    <ol>
        <li>Purchase the product securely.</li>
        <li>Access the download, preview, or delivery instructions.</li>
        <li>Review the included guide or documentation.</li>
        <li>Customize, deploy, publish, or apply it to your project.</li>
    </ol>

    <h3>Frequently Asked Questions</h3>
    <p><strong>Can I customize this product?</strong><br>Yes. The product is designed to be adapted for your own use case where applicable.</p>
    <p><strong>Is this suitable for beginners?</strong><br>Yes. The structure is clear enough for beginners while still useful for experienced users.</p>
    <p><strong>How is it delivered?</strong><br>__DELIVERY_TYPE__. Check the product delivery or preview link if available.</p>
</section>
</template>

<script>
function getPremiumProductTemplateData() {
    const productName = ($('#name').val() || 'Premium Digital Product').trim();
    const category = ($('#category option:selected').text() || $('#category').val() || 'digital').trim();
    const isDigital = $('#digital').val() !== '0';

    return {
        productName: productName,
        category: category === 'Select Category' ? 'digital' : category,
        deliveryType: isDigital ? 'Digital delivery' : 'Physical or manual delivery'
    };
}

function buildPremiumProductDescriptionTemplate() {
    const template = document.getElementById('premiumProductDescriptionTemplate');
    if (!template) {
        return '';
    }

    const data = getPremiumProductTemplateData();

    return template.innerHTML
        .replaceAll('__PRODUCT_NAME__', data.productName)
        .replaceAll('__CATEGORY__', data.category)
        .replaceAll('__DELIVERY_TYPE__', data.deliveryType)
        .trim();
}

window.applyPremiumProductTemplate = function(forceReplace) {
    const html = buildPremiumProductDescriptionTemplate();
    const textarea = $('#detailed_description');
    const currentValue = window.detailedEditor ? window.detailedEditor.getData().trim() : textarea.val().trim();

    if (!forceReplace && currentValue.length > 0 && !confirm('Replace the current detailed description with the premium product template?')) {
        return;
    }

    if (window.detailedEditor) {
        window.detailedEditor.setData(html);
    }

    textarea.val(html);
};
</script>
