# How it works

`is-style-horizontal-form` - делает форму горизонтальной

`mphbs-hide-labels` - убирает лейблы

`mphbs-no-paddings` - убирает паддинги

`mphbs-hide-rf-tip` - убирает реквайред филдс тип

`mphbs-wrap` - добавляет форме перенос(по-дефолту без переноса)

`mphbs-fluid-button` - "тянет" кнопку на всю доступную ширину

`mphbs-fw-20, mphbs-fw-25, mphbs-fw-33, mphbs-fw-50, mphbs-fw-100` - ширина контролов

`is-direct-booking` - для букинг формы одной комнаты(если включен директ букинг) работает только с классом is-style-horizontal-form

**Класс `is-direct-booking` добавляется через фильтр**

## Create a POT file
1. Install WP-CLI and add to PATH https://wp-cli.org/#installing
1. Navigate to ./languages
1. Run `wp i18n make-pot ./..`

To subtract new strings run `wp i18n make-pot ./.. mphb-styles-new.pot --subtract="mphb-styles.pot"`
