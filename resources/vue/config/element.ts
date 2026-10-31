import { ElAlert, ElButton, ElFormItem, ElDialog, ElRow } from 'element-plus'

// -----------------------------------
// alert
ElAlert.setPropsDefaults({
    closable: false,
    type: 'primary',
})

// -----------------------------------
// button
ElButton.setPropsDefaults({
    size: 'small',
})

// -----------------------------------
// form item
ElFormItem.setPropsDefaults({
    labelPosition: 'top',
})

// -----------------------------------
// row
ElRow.setPropsDefaults({
    gutter: 4,
})

// -----------------------------------
// ...
