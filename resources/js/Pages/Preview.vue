<template>
    <AppLayout :title="canPrint ? printTitle : title">
        <div class="flex items-center justify-center p-5 w-full border-b shadow mb-7" v-show="!canPrint">
            <div class="flex items-center justify-between" style="width: 595.28px">
                <Link :href="route('show')" as="button" class="flex text-white bg-amber-500 hover:bg-amber-600 text-sm items-center justify-center rounded px-5 py-1.5">
                    Home
                </Link>
                <div class="flex space-x-3">
                    <span class="uppercase">Color theme</span>
                    <div class="flex space-x-2 rounded items-center">
                        <ColorThemeButton @click="changeColor('slate')" :class="color !== 'slate' ? 'bg-slate-500' : ''" class="border-slate-500" :active="color === 'slate'"/>
                        <ColorThemeButton @click="changeColor('gray')" :class="color !== 'gray' ? 'bg-gray-600' : ''" class="border-gray-600" :active="color === 'gray'"/>
                        <ColorThemeButton @click="changeColor('green')" :class="color !== 'green' ? 'bg-lime-600' : ''" class="border-lime-600" :active="color === 'green'"/>
                        <ColorThemeButton @click="changeColor('amber')" :class="color !== 'amber' ? 'bg-amber-600' : ''" class="border-amber-600" :active="color === 'amber'"/>
                        <ColorThemeButton @click="changeColor('rose')" :class="color !== 'rose' ? 'bg-rose-700' : ''" class="border-rose-700" :active="color === 'rose'"/>
                        <ColorThemeButton @click="changeColor('violet')" :class="color !== 'violet' ? 'bg-violet-800' : ''" class="border-violet-800" :active="color === 'violet'"/>
                        <ColorThemeButton @click="changeColor('blue')" :class="color !== 'blue' ? 'bg-blue-800' : ''" class="border-blue-800" :active="color === 'blue'"/>
                    </div>
                </div>
                <Button @click="downloadPDF">Download PDF</Button>
            </div>
        </div>

        <div :class="canPrint ? 'h-screen' : ''" class="flex justify-center items-center">
            <div :class="canPrint ? 'scale-[1.35]' : ''" class="border flex justify-center items-center border shadow overflow-hidden">
                <div id="page" ref="page" class="flex flex-row" style="width: 595.28px; height: 842px">

                    <div class="w-1/3 bg-gray-50 text-xs space-y-6 pl-5 pr-7 py-7 overflow-hidden">
                        <div class="flex items-center space-y-7 flex-col">
                            <div v-if="owner.first_name || owner.last_name" class="flex flex-col w-full">
                                <div :class="headingColor" class="uppercase font-bold text-xl">
                                    {{ owner.first_name }} {{ owner.last_name }}
                                </div>
                                <div class="text-base">{{ owner.profession }}</div>
                            </div>
                            <div class="flex flex-col space-y-2 w-full">
                                <h3 :class="headingColor" class="font-bold uppercase text-sm">Contacts</h3>
                                <div v-if="owner.phone_number" class="flex items-center space-x-1.5">
                                    <font-awesome-icon icon="fa-solid fa-phone" />
                                    <span>{{ owner.phone_number }}</span>
                                </div>
                                <div v-if="owner.email" class="flex items-center space-x-1.5">
                                    <font-awesome-icon icon="fa-solid fa-envelope" />
                                    <span>{{ owner.email }}</span>
                                </div>
                                <div v-if="owner.city" class="flex items-center space-x-1.5">
                                    <font-awesome-icon icon="fa-solid fa-location-dot" />
                                    <span v-if="owner.city">{{ owner.city }}, {{ owner.country }}</span>
                                </div>
                            </div>

                            <div v-if="socials.length > 0" class="flex flex-col w-full space-y-2">
                                <h3 :class="headingColor" class="font-bold uppercase text-sm">Social Links</h3>
                                <div class="flex space-x-2 items-center" v-for="(social, index) in socials" :key="index">
                                    <font-awesome-icon v-if="social.type === 'linkedin'" icon="fa-brands fa-linkedin"/>
                                    <font-awesome-icon v-if="social.type === 'github'" icon="fa-brands fa-github"/>
                                    <font-awesome-icon v-if="social.type === 'website'" icon="fa-solid fa-globe" />
                                    <a :href="social.link" target="_blank">
                                        <span v-if="social.type === 'linkedin'">Linkedin</span>
                                        <span v-if="social.type === 'github'">Github</span>
                                        <span v-if="social.type === 'website'">Website</span>
                                    </a>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1 w-full">
                                <h3 :class="headingColor" class="font-bold uppercase text-sm">Skills</h3>
                                <div class="flex flex-col space-y-3">
                                    <div class="flex flex-row items-center flex-wrap">
                                        <div  v-for="item in skills" :class="itemColor" class="px-2 py-1 mt-2 mr-1 flex items-center text-white rounded">
                                            {{ item.skill }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1 w-full">
                                <h3 :class="headingColor" class="font-bold uppercase text-sm">Languages</h3>
                                <div class="flex flex-col space-y-3">
                                    <div class="flex flex-row items-center flex-wrap">
                                    <span v-for="item in languages" :key="item.id" :class="itemColor" class="px-2 py-1 mr-1 mt-2 flex items-center text-white rounded">
                                        {{ item.language }}
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-2/3 flex text-xs flex-col space-y-6 px-5 pt-7 pb-16">

                        <div class="flex flex-col space-y-3">
                            <h3 :class="headingColor" class="font-bold uppercase text-sm">About me</h3>
                            <span class="border-solid border-2 border-gray-500 w-full"></span>
                            <div class="text-xs">{{ owner.description }}</div>
                        </div>

                        <div class="flex flex-col space-y-3">
                            <h3 :class="headingColor" class="font-bold uppercase text-sm">Work Experience</h3>
                            <span class="border-solid border-2 border-gray-500 w-full"></span>
                            <div v-for="work in workHistory" :key="work.id" class="flex space-y-2 flex-col">
                                <div class="font-bold pt-2">{{ work.job_title }} at {{ work.employer }}</div>
                                <div class="text-gray-600">{{ date(work.start) }} - {{ date(work.end) }}</div>
                                <p>{{ work.description }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-4">
                            <h3 :class="headingColor" class="font-bold uppercase text-sm">Education</h3>
                            <span class="border-solid border-gray-500 border-2 w-full"></span>
                            <div class="space-y-5">
                                <div v-for="institutions in educationInstitutions" :key="institutions.id" class="flex space-y-2 flex-col">
                                    <span class="font-bold">{{ institutions.field_of_study }}</span>
                                    <span class="text-gray-600" v-if="institutions.currently_attending">
                                        {{ date(institutions.started_at) }} - Current
                                    </span>
                                    <span class="text-gray-600" v-else>
                                        <span>
                                            {{ date(institutions.started_at) }} - {{ date(institutions.ended_at) }}
                                        </span>
                                    </span>
                                    <span>{{ institutions.institution }}</span>
                                    <span>{{ institutions.degree }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import Button from '../Components/Button.vue'
import ColorThemeButton from "../Components/ColorThemeButton.vue";
import {Link} from "@inertiajs/inertia-vue3";
import {computed, ref} from "vue";

const props = defineProps({
    owner: Object,
    educationInstitutions: Array,
    workHistory: Array,
    skills: Array,
    languages: Array,
    socials: Array
})

const color = ref('rose')
const title = props.owner.first_name + ' ' + props.owner.last_name + ' Resume'
let printTitle = `${props.owner.first_name}_${props.owner.last_name}_Resume`.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
const changeColor = (colorChoice) => {
    color.value = colorChoice
}


const itemColor = computed(() => {
    return {
        'bg-slate-500' : color.value === 'slate',
        'bg-gray-600' : color.value === 'gray',
        'bg-amber-600' : color.value === 'amber',
        'bg-blue-800' : color.value === 'blue',
        'bg-lime-600' : color.value === 'green',
        'bg-violet-800' : color.value === 'violet',
        'bg-rose-700' : color.value === 'rose',
    }
});

const headingColor = computed(() => {
    return {
        'text-slate-600' : color.value === 'slate',
        'text-gray-900' : color.value === 'gray',
        'text-amber-900' : color.value === 'amber',
        'text-blue-900' : color.value === 'blue',
        'text-lime-900' : color.value === 'green',
        'text-violet-900' : color.value === 'violet',
        'text-rose-900' : color.value === 'rose',
    }
});

let canPrint = ref(false)

const downloadPDF = () => {
    canPrint.value = true
    setTimeout(window.print, 100);
    setTimeout(() => canPrint.value = false, 200);
}

const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

const date = (date) => {
    let dt = new Date(date);
    return monthNames[dt.getMonth()] + ' ' + dt.getFullYear()
}

</script>
