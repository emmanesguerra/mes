<template>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="col-sm-12">
                <div  class="form-group row">
                    <h4>Website Profile</h4>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.domain_name ? 'text-danger' : ''" for="domain_name">Domain name *</label>
                        <input type="text" v-bind:class="errors.domain_name ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="domain_name" v-model="mdata.domain_name" placeholder="ex. your.website.com">
                        <form-error v-if="errors.domain_name" :errors="errors.domain_name">
                            {{ errors.domain_name }}
                        </form-error>
                    </div>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.website_name ? 'text-danger' : ''"  for="website_name">Website name *</label>
                        <input type="text" v-bind:class="errors.website_name ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="website_name" v-model="mdata.website_name" placeholder="ex. Your Website">
                        <form-error v-if="errors.website_name" :errors="errors.website_name">
                            {{ errors.website_name }}
                        </form-error>
                    </div>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.owner ? 'text-danger' : ''"  for="owner">Owner</label>
                        <input type="text" v-bind:class="errors.owner ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="owner" v-model="mdata.owner" placeholder="Owner's name">
                        <form-error v-if="errors.owner" :errors="errors.owner">
                            {{ errors.owner }}
                        </form-error>
                    </div>
                </div>
                <div  class="form-group row mt-3">
                    <h4>For SEO purposes</h4>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.meta_title ? 'text-danger' : ''" for="meta_title">Default Page Title *</label>
                        <input type="text" v-bind:class="errors.meta_title ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="meta_title" v-model="mdata.meta_title" placeholder="Default page title">
                        <form-error v-if="errors.meta_title" :errors="errors.meta_title">
                            {{ errors.meta_title }}
                        </form-error>
                    </div>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.meta_keywords ? 'text-danger' : ''" for="meta_keywords">Keywords/Tags</label>
                        <input type="text" v-bind:class="errors.meta_keywords ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="meta_keywords" v-model="mdata.meta_keywords" placeholder="Default page keywords">
                        <form-error v-if="errors.meta_keywords" :errors="errors.meta_keywords">
                            {{ errors.meta_keywords }}
                        </form-error>
                    </div>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.meta_description ? 'text-danger' : ''" for="meta_description">Page Description *</label>
                        <textarea v-bind:class="errors.meta_description ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                                  id="meta_description" v-model="mdata.meta_description" placeholder="Default page description" rows="5"></textarea>
                        <form-error v-if="errors.meta_description" :errors="errors.meta_description">
                            {{ errors.meta_description }}
                        </form-error>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="col-sm-12">

                <div  class="form-group row">
                    <h4>Email Settings</h4>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.email_recipients ? 'text-danger' : ''" for="email_recipients">Recipients</label>
                        <input type="text" v-bind:class="errors.email_recipients ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="email_recipients" v-model="mdata.email_recipients" placeholder="Recipient">
                        <form-error v-if="errors.email_recipients" :errors="errors.email_recipients">
                            {{ errors.email_recipients }}
                        </form-error>
                    </div>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.email_cc ? 'text-danger' : ''" for="email_cc">CCs</label>
                        <input type="text" v-bind:class="errors.email_cc ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="email_cc" v-model="mdata.email_cc" placeholder="Cc">
                        <form-error v-if="errors.email_cc" :errors="errors.email_cc">
                            {{ errors.email_cc }}
                        </form-error> 
                    </div>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.email_bcc ? 'text-danger' : ''"  for="email_bcc">BCCs</label>
                        <input type="text" v-bind:class="errors.email_bcc ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="email_bcc" v-model="mdata.email_bcc" placeholder="Bcc">
                        <form-error v-if="errors.email_bcc" :errors="errors.email_bcc">
                            {{ errors.email_bcc }}
                        </form-error>
                    </div>
                </div>
                <div  class="form-group row mt-3">
                    <h4>Server Settings</h4>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.developer ? 'text-danger' : ''" for="developer">Developer</label>
                        <input type="text" v-bind:class="errors.developer ? 'form-control ae-input-field is-invalid' : 'form-control ae-input-field'" 
                               id="developer" v-model="mdata.developer" placeholder="Developer's name">
                        <form-error v-if="errors.developer" :errors="errors.developer">
                            {{ errors.developer }}
                        </form-error>
                    </div>
                </div>
                <div class="form-row">
                    <div  class="form-group  col-sm-12">
                        <label v-bind:class="errors.timezone ? 'text-danger' : ''" for="timezone">Timezone *</label>
                        <treeselect  v-bind:class="errors.timezone ? 'ae-input-field is-invalid' : 'ae-input-field'" 
                                     v-model="mdata.timezone"
                                     :multiple="false"
                                     :options="options"
                                     placeholder="Select a timezone" /> 
                        <form-error v-if="errors.timezone" :errors="errors.timezone">
                            {{ errors.timezone }}
                        </form-error>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <button data-toggle="modal" data-target="#settingsModal" type="button" class="btn btn-primary">Submit</button>
            <button @click="reset" type="button" class="btn btn-secondary">Clear</button>
        </div>
        <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settingsModalLabel">Continue Posting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Continue saving records?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button @click="submit"  type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FormError from '../FormError.vue';

    import Treeselect from '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.css';

    export default {
        props: ['info', 'timezones', 'settingindexurl'],
        data: function () {
            return {
                mdata: this.info,
                errors: {},
                options: this.timezones.map(i => ({
                        id: i,
                        label: `${i}`
                    }))
            }
        },
        mounted() {
        },
        components: {
            FormError, Treeselect
        },
        methods: {
            reset() {
                this.mdata = {};
            },
            submit() {
                var vm = this;
                axios.post(this.settingindexurl, this.mdata).then(function (response) {
                    vm.errors = {};
                    processnoti('noti', 'success', '', response.data.message);
                    $('#settingsModal').modal('hide');
                }).catch(function (error) {
                    if (error.response) {
                        vm.errors = error.response.data.errors;
                    }
                    $('#settingsModal').modal('hide');
                    processnoti('noti', 'error', '', error.response.data.message);
                });
            }
        }
    }
</script>