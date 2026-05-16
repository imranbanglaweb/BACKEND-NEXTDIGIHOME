let changed = new Set();
let autoSaveTimers = {};

/* ===== TOAST ===== */
function notify(msg, type='info', loading=false){
    const c = document.getElementById('notification-container');
    if(!c) return;

    const t = document.createElement('div');
    t.className = 'toast';
    t.style.background =
        type === 'success' ? '#16a34a' :
        type === 'error'   ? '#dc2626' :
        type === 'warning' ? '#d97706' : '#2563eb';

    t.innerHTML = `<span>${msg}</span>${loading?'<span class="spinner"></span>':''}`;
    c.appendChild(t);

    setTimeout(()=>{
        t.classList.add('hide');
        setTimeout(()=>t.remove(),350);
    },2500);
}

/* ===== LOAD TRANSLATIONS ===== */
function loadTranslations(page=1){
    const s = document.getElementById('search-input').value;
    fetch(`${window.ROUTES.ajax}?page=${page}&search=${encodeURIComponent(s)}`)
        .then(r=>r.json())
        .then(r=>{
            renderRows(r.translations);
            renderPagination(r.pagination);
        })
        .catch(()=>notify('Load failed','error'));
}

/* ===== RENDER ROWS ===== */
function renderRows(rows){
    const tbody = document.getElementById('translations-table-body');
    tbody.innerHTML = '';

    rows.forEach(r=>{
        let html = `
        <tr>
            <td><input type="checkbox" class="row-check" data-id="${r.id}"></td>
            <td>${r.key}</td>
            <td>${r.group}</td>`;

        window.LANGUAGES.forEach(l=>{
            html += `
            <td>
                <input class="form-control translation-input"
                       data-id="${r.id}"
                       data-lang="${l}"
                       value="${r.values[l]||''}"
                       oninput="markChanged(this)">
            </td>`;
        });

        html += `
        <td>
            <button class="btn btn-sm btn-primary me-1" onclick="inlineSave(${r.id})">
                <i class="fa fa-save"></i>
            </button>
            <button class="btn btn-sm btn-success" onclick="inlineAutoTranslate(${r.id})">
                <i class="fa fa-language"></i>
            </button>
        </td></tr>`;

        tbody.insertAdjacentHTML('beforeend', html);
    });

    // Reset select all
    document.getElementById('select-all').checked = false;
}

/* ===== INLINE SAVE ===== */
function markChanged(i){
    const id = i.dataset.id;
    i.classList.add('changed');
    changed.add(id);
    document.getElementById('bulk-save-btn').disabled = false;

    clearTimeout(autoSaveTimers[id]);
    autoSaveTimers[id] = setTimeout(()=>inlineSave(id),1200);
}

function inlineSave(id, notifyOnSave = true){
    const inputs = document.querySelectorAll(`.translation-input[data-id="${id}"]`);
    let data = {};
    inputs.forEach(i=>data[i.dataset.lang]=i.value);

    if(notifyOnSave) notify('Saving...','info',true);

    return fetch(window.ROUTES.update,{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':window.CSRF_TOKEN
        },
        body:JSON.stringify({translation_id:id,translations:data})
    })
    .then(r=>r.json())
    .then(()=>{
        inputs.forEach(i=>i.classList.remove('changed'));
        changed.delete(String(id));
        if(notifyOnSave) notify('Saved','success');
    });
}

/* ===== INLINE AUTO TRANSLATE ROW ===== */
function inlineAutoTranslate(id, notifyOnTranslate = true){
    const sourceInput = document.querySelector(`.translation-input[data-id="${id}"][data-lang="en"]`);
    if(!sourceInput || !sourceInput.value.trim()) {
        if(notifyOnTranslate) notify('Source text not found','error');
        return Promise.reject('Source text not found');
    }

    const sourceText = sourceInput.value.trim();

    return fetch(window.ROUTES.auto,{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':window.CSRF_TOKEN
        },
        body: JSON.stringify({
            translation_id: id,
            source_text: sourceText // <-- ADDED: required by controller
        })
    })
    .then(res => res.json())
    .then(data => { 
        if(data.success){
            // <-- ADDED: populate input boxes directly from response
            for(const [lang, text] of Object.entries(data.translations)){
                const input = document.querySelector(`.translation-input[data-id="${id}"][data-lang="${lang}"]`);
                if(input) input.value = text || '';
            }

            if(notifyOnTranslate) notify('Translated','success');
        } else {
            if(notifyOnTranslate) notify('Translation failed','error');
        }
    })
    .catch(err=>{
        console.error(err);
        if(notifyOnTranslate) notify('Server error','error');
        throw err;
    });
}


/* ===== BULK SAVE ===== */
function updateBulkSaveButton() {
    const anyChecked = document.querySelectorAll('.row-check:checked').length > 0;
    document.getElementById('bulk-save-btn').disabled = !anyChecked;
}

document.getElementById('bulk-save-btn').onclick = () => {
    const selectedIds = Array.from(document.querySelectorAll('.row-check:checked'))
                             .map(cb => cb.dataset.id);
    
    if (selectedIds.length === 0) return;

    const overlay = document.getElementById('progress-overlay');
    const title = document.getElementById('progress-title');
    const fill = document.getElementById('progress-fill');
    const message = document.getElementById('progress-message');
    const log = document.getElementById('progress-key');
    const spinner = document.querySelector('.progress-spinner');
    const checkmark = document.querySelector('.success-checkmark');
    const barWrapper = document.querySelector('.progress-bar-wrapper');

    overlay.style.display = 'flex';
    title.innerText = 'Saving...';
    log.innerText = 'Initializing...';
    fill.style.width = '0%';
    fill.style.background = 'linear-gradient(90deg, #ef4444, #f97316)';
    message.innerText = '0% Completed';
    spinner.style.display = 'block';
    if(checkmark) checkmark.style.display = 'none';
    barWrapper.style.display = 'block';
    
    let completed = 0;

    const savePromises = selectedIds.map(id => {
        return inlineSave(id, false)
            .then(() => {
                completed++;
                const progress = Math.round((completed / selectedIds.length) * 100);
                fill.style.width = progress + '%';
                message.innerText = progress + '% Completed';

                const checkbox = document.querySelector(`.row-check[data-id="${id}"]`);
                const row = checkbox?.closest('tr');
                const key = row ? row.cells[1].innerText : id;
                log.innerText = 'Processed: ' + key;

                if (progress < 30) {
                    fill.style.background = 'linear-gradient(90deg, #ef4444, #f97316)';
                } else if (progress < 70) {
                    fill.style.background = 'linear-gradient(90deg, #f97316, #eab308)';
                } else {
                    fill.style.background = 'linear-gradient(90deg, #22c55e, #10b981)';
                }
            });
    });

    Promise.all(savePromises).then(() => {
        spinner.style.display = 'none';
        barWrapper.style.display = 'none';
        if(checkmark) checkmark.style.display = 'block';
        title.innerText = 'Completed!';
        message.innerText = '';
        log.innerText = '';
        notify('All translations saved successfully!', 'success');

        setTimeout(() => {
            overlay.style.display = 'none';
        }, 2000);

        document.querySelectorAll('.row-check:checked').forEach(cb => cb.checked = false);
        document.getElementById('select-all').checked = false;
        updateBulkSaveButton();
    }).catch(err => {
        title.innerText = 'Error!';
        message.innerText = 'An error occurred.';
        log.innerText = '';
        notify('An error occurred during bulk save.', 'error');
        console.error(err);

        setTimeout(() => {
            overlay.style.display = 'none';
        }, 2000);
    });
};

/* ===== BULK AUTO TRANSLATE ===== */
document.getElementById('bulk-auto-btn').onclick = ()=>{
    const selectedIds = Array.from(document.querySelectorAll('.row-check:checked'))
                             .map(cb => cb.dataset.id);
    if(selectedIds.length === 0) {
        notify('Please select rows to auto translate','warning');
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to auto-translate " + selectedIds.length + " items. This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, translate it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const overlay = document.getElementById('progress-overlay');
            const title = document.getElementById('progress-title');
            const fill = document.getElementById('progress-fill');
            const message = document.getElementById('progress-message');
            const log = document.getElementById('progress-key');
            const spinner = document.querySelector('.progress-spinner');
            const checkmark = document.querySelector('.success-checkmark');
            const barWrapper = document.querySelector('.progress-bar-wrapper');

            overlay.style.display = 'flex';
            title.innerText = 'Translating...';
            log.innerText = 'Initializing...';
            fill.style.width = '0%';
            fill.style.background = 'linear-gradient(90deg, #ef4444, #f97316)';
            message.innerText = '0% Completed';
            spinner.style.display = 'block';
            if(checkmark) checkmark.style.display = 'none';
            barWrapper.style.display = 'block';

            let completed = 0;

            const translatePromises = selectedIds.map(id => {
                return inlineAutoTranslate(id, false)
                    .then(() => {
                        completed++;
                        const progress = Math.round((completed / selectedIds.length) * 100);
                        fill.style.width = progress + '%';
                        message.innerText = progress + '% Completed';

                        const checkbox = document.querySelector(`.row-check[data-id="${id}"]`);
                        const row = checkbox?.closest('tr');
                        const key = row ? row.cells[1].innerText : id;
                        log.innerText = 'Processed: ' + key;

                        if (progress < 30) {
                            fill.style.background = 'linear-gradient(90deg, #ef4444, #f97316)';
                        } else if (progress < 70) {
                            fill.style.background = 'linear-gradient(90deg, #f97316, #eab308)';
                        } else {
                            fill.style.background = 'linear-gradient(90deg, #22c55e, #10b981)';
                        }
                    })
                    .catch(err => {
                        console.error(`Failed to auto translate ID ${id}:`, err);
                    });
            });

            Promise.all(translatePromises).then(() => {
                spinner.style.display = 'none';
                barWrapper.style.display = 'none';
                if(checkmark) checkmark.style.display = 'block';
                title.innerText = 'Completed!';
                message.innerText = '';
                log.innerText = '';
                notify('All translations completed successfully!', 'success');

                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 2000);

                document.querySelectorAll('.row-check:checked').forEach(cb => cb.checked = false);
                document.getElementById('select-all').checked = false;
                updateBulkSaveButton();
            });
        }
    });
};

/* ===== INSERT NEW TRANSLATION ===== */
function insertTranslation(){
    let values = {};
    document.querySelectorAll('.new-value').forEach(i=>{ values[i.dataset.lang] = i.value; });

    fetch(window.ROUTES.create,{
        method:'POST',
        headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':window.CSRF_TOKEN },
        body:JSON.stringify({
            group:document.getElementById('new-group').value,
            key:document.getElementById('new-key').value,
            values
        })
    }).then(()=>{
        notify('Added','success');
        bootstrap.Modal.getInstance(document.getElementById('addTranslationModal')).hide();
        loadTranslations();
    });
}

/* ===== PAGINATION ===== */
function renderPagination(p){
    const w = document.getElementById('pagination-wrapper');
    w.innerHTML = '';
    for(let i=1;i<=p.last_page;i++){
        w.innerHTML += `<button class="btn btn-sm ${i===p.current_page?'btn-primary':'btn-light'}"
            onclick="loadTranslations(${i})">${i}</button> `;
    }
}

/* ===== SEARCH ===== */
document.getElementById('search-input').oninput = ()=>loadTranslations();

/* ===== SELECT ALL FUNCTIONALITY ===== */
const selectAllCheckbox = document.getElementById('select-all');

selectAllCheckbox.addEventListener('change', function(){
    const allRows = document.querySelectorAll('.row-check');
    allRows.forEach(cb => cb.checked = selectAllCheckbox.checked);
    updateBulkSaveButton();
});

document.addEventListener('change', function(e){
    if(e.target && e.target.classList.contains('row-check')){
        const allRows = document.querySelectorAll('.row-check');
        const checkedRows = document.querySelectorAll('.row-check:checked');
        selectAllCheckbox.checked = allRows.length === checkedRows.length;
        updateBulkSaveButton();
    }
});

document.addEventListener('DOMContentLoaded',()=>loadTranslations());

const groupInput = document.getElementById('new-group');
const keyInput = document.getElementById('new-key');
const langInputs = document.querySelectorAll('.new-value');
const submitBtn = document.getElementById('add-translation-submit');

/* Validate a single field */
function validateField(input){
    const value = input.value.trim();
    const lang = input.dataset.lang;
    const errorDiv = document.getElementById(lang ? `error-${lang}` : `error-${input.id.split('-')[1]}`);

    // Only English is required
    if(lang && lang.toLowerCase() !== 'en'){
        input.classList.remove('is-invalid');
        input.classList.remove('is-valid');
        errorDiv.textContent = '';
        return true;
    }

    if(!value){
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        errorDiv.textContent = 'This field is required';
        input.classList.add('shake');
        setTimeout(()=>input.classList.remove('shake'),300);
        return false;
    } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        errorDiv.textContent = '';
        return true;
    }
}

/* Live validation */
[groupInput,keyInput,...langInputs].forEach(input=>{
    input.addEventListener('input', ()=>validateField(input));
});

/* Submit handler */
submitBtn.onclick = function(){
    let valid = true;

    // Validate group + key
    valid &= validateField(groupInput);
    valid &= validateField(keyInput);

    // Validate English only
    const values = {};
    langInputs.forEach(input=>{
        const val = input.value.trim();
        values[input.dataset.lang] = val;
        valid &= validateField(input);
    });

    if(!valid) return;

    // Submit via AJAX
    fetch(window.ROUTES.create,{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':window.CSRF_TOKEN
        },
        body:JSON.stringify({
            group: groupInput.value.trim(),
            key: keyInput.value.trim(),
            values
        })
    })
    .then(r=>r.json())
    .then(res=>{
        notify(res.message || 'Added successfully','success');

        bootstrap.Modal.getInstance(document.getElementById('addTranslationModal')).hide();

        // Reset inputs
        groupInput.value='';
        keyInput.value='';
        langInputs.forEach(i=>i.value='');
        [groupInput,keyInput,...langInputs].forEach(i=>{
            i.classList.remove('is-invalid','is-valid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(d=>d.textContent='');

        loadTranslations();
    })
    .catch(()=>notify('Failed to add translation','error'));
};
