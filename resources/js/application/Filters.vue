<script lang="ts" setup>
import {computed, reactive, ref} from "vue";

const selectedVersion = ref();
const fieldsPresence = ref(true);
const selectedFields = ref(['phone', 'email']);
const selectedCustomFields = ref(['full_name', 'country']);
const quantity = ref(10);
const sortDirection = ref('ASC');
const format = ref('xml');
const sortOptions = [
    {
        title: 'Ascending',
        value: 'ASC'
    },
    {
        title: 'Descending',
        value: 'DESC'
    }];
const versions = ref([]);
const fields = ref([]);
const customFields = ref([]);
const loading = ref(false);
const fetchVersions = async (e) => {
    if (e) {
        loading.value = true
        try {
            const response = await fetch('/api/random-user/versions');
            versions.value = await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
        }
        loading.value = false
    }
};
const fetchFields = async (e) => {
    if (e) {
        loading.value = true
        try {
            const response = await fetch('/api/random-user/fields');
            fields.value = await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
        }
        loading.value = false
    }
};

const fetchCustomFields = async (e) => {
    if (e) {
        loading.value = true
        try {
            const response = await fetch('/api/random-user/custom-fields');
            customFields.value = await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
        }
        loading.value = false
    }
};

function capitalizeFirstLetter(str) {
    str = str.replace('_', ' ');
    return str.substring(0, 1).toUpperCase() + str.substring(1);
}

function toggle() {
    if (allFieldsSelected.value) {
        selectedFields.value = []
    } else {
        selectedFields.value = fields.value.slice()
    }
}

const allFieldsSelected = computed(() => selectedFields.value.length === fields.value.length);
const someFieldsSelected = computed(() => selectedFields.value.length > 0);

const emit = defineEmits(['button-clicked']);

const applySettings = () => {
    let queryObject = {}
    if (fieldsPresence.value) {
        queryObject = {inc: selectedFields.value}
    } else {
        queryObject = {exc: selectedFields.value}
    }
    emit('button-clicked', {
        ...queryObject,
        results: quantity.value,
        sort_by: sortDirection.value,
        customFields: selectedCustomFields.value,
        output_format: format.value,
        version: selectedVersion.value
    });
};
</script>

<template>
    <v-row class="align-center justify-center">
        <v-col cols="4">
            <v-select v-model="selectedVersion" :items="versions" :loading="loading" label="Api versions"
                      @update:menu="fetchVersions"></v-select>
        </v-col>
        <v-col cols="4">
            <v-select v-model="selectedFields" :items="fields" :loading="loading" chips clearable item-props
                      label="Fields"
                      multiple @update:menu="fetchFields">
                <template v-slot:prepend-item>
                    <v-list-item
                        title="Select All"
                        @click="toggle"
                    >
                        <template v-slot:prepend>
                            <v-checkbox-btn
                                :color="someFieldsSelected ? 'indigo-darken-4' : undefined"
                                :indeterminate="someFieldsSelected && !allFieldsSelected"
                                :model-value="allFieldsSelected"
                            ></v-checkbox-btn>
                        </template>
                    </v-list-item>

                    <v-divider class="mt-2"></v-divider>
                </template>
                <template v-slot:item="{ props, item }">
                    <v-list-item
                        :prepend-icon="selectedFields.includes(item.title) ? 'mdi-checkbox-marked-outline' : 'mdi-checkbox-blank-outline'"
                        :title="capitalizeFirstLetter(item.title)"
                        v-bind="props"></v-list-item>
                </template>
            </v-select>
        </v-col>
        <v-col cols="4">
            Exclude or include fields. Fields will be:
            <v-checkbox v-model="fieldsPresence" :label="fieldsPresence ? 'Included' : 'Excluded'"></v-checkbox>
        </v-col>
        <v-col cols="4">
            <v-select v-model="selectedCustomFields" :items="customFields" :loading="loading" chips clearable
                      label="Custom fields" multiple @update:menu="fetchCustomFields">
                <template v-slot:item="{ props, item }">
                    <v-list-item
                        :prepend-icon="selectedCustomFields.includes(item.title) ? 'mdi-checkbox-marked-outline' : 'mdi-checkbox-blank-outline'"
                        :title="capitalizeFirstLetter(item.title)"
                        v-bind="props"></v-list-item>
                </template>
            </v-select>
        </v-col>
        <v-col cols="4">
            <v-text-field v-model="quantity" label="How many results" min="1" type="number"/>
        </v-col>
        <v-col cols="4">
            <v-select v-model="sortDirection" :items="sortOptions" label="Sort by last name"/>
        </v-col>
        <v-col cols="4">
            <v-btn-toggle
                v-model="format"
                divided
            >
                <v-btn color="info" value="json">
                    <v-icon start>
                        mdi-code-json
                    </v-icon>
                    JSON
                </v-btn>
                <v-btn color="warning" value="xml">
                    <v-icon start>
                        mdi-xml
                    </v-icon>
                    XML
                </v-btn>
            </v-btn-toggle>
        </v-col>
        <v-col cols="auto">
            <v-btn color="success" @click="applySettings">
                <v-icon start>
                    mdi-check
                </v-icon>
                Apply settings
            </v-btn>
        </v-col>
    </v-row>
</template>

