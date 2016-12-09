$(document).ready(function() {
    $('.ui.dropdown').dropdown({
        onChange: function(value, text, $selectedItem) {
            if (value == 'tracksurvey' || value == 'boothsurvey') {
                var effect = {
                    animation : 'horizontal flip',
                    duration  : 800,
                };
                function show_survey() {
                    $('#'+value).transition(effect);
                }
                if ($('.nvsurvey:visible').length) {
                    $('.nvsurvey:visible').transition(effect);
                    setTimeout(function() {
                        show_survey();
                    }, 800);
                } else {
                    show_survey();
                }
            }
        }
    });

    $('#mauticform_hpcchina2016surveybooth').form({
        fields: {
            mauticform_input_hpcchina2016surveybooth_yi_xia_na_xie_shi_nin_gan: 'empty',
            mauticform_input_hpcchina2016surveybooth_nin_jin_qi_shi_fou_you_ca: 'empty',
            mauticform_input_hpcchina2016surveybooth_nvidia: 'empty',
            mauticform_input_hpcchina2016surveybooth_cumpl: 'empty',
            mauticform_input_hpcchina2016surveybooth_rseft: 'empty',
            mauticform_input_hpcchina2016surveybooth_doarc: 'empty',
            mauticform_input_hpcchina2016surveybooth_email1: 'empty',
            mauticform_input_hpcchina2016surveybooth_yarne: ['minLength[11]', 'empty']
        }
    });

    $('#mauticform_hpcchina2016surveytrack').form({
        fields: {
            mauticform_input_hpcchina2016surveytrack_yi_xia_na_xie_shi_nin_gan: 'empty',
            mauticform_input_hpcchina2016surveytrack_nin_jin_qi_shi_fou_you_ca: 'empty',
            mauticform_input_hpcchina2016surveytrack_nvidia: 'empty',
            mauticform_input_hpcchina2016surveytrack_nin_hui_fou_dui_shi_jie_s: 'empty',
            mauticform_input_hpcchina2016surveytrack_nin_jin_qi_shi_fou_you_ji: 'empty',
            mauticform_input_hpcchina2016surveytrack_ruo_you_ji_hua_cai_goudgx: 'empty',
            mauticform_input_hpcchina2016surveytrack_cumpl: 'empty',
            mauticform_input_hpcchina2016surveytrack_rseft: ['empty'],
            mauticform_input_hpcchina2016surveytrack_xing_ye: 'empty',
            mauticform_input_hpcchina2016surveytrack_doarc: ['empty'],
            mauticform_input_hpcchina2016surveytrack_email1: 'empty',
            mauticform_input_hpcchina2016surveytrack_yarne: ['minLength[11]', 'empty']
        }
    });
});
