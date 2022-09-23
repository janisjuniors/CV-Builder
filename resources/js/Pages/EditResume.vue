<template>
    <AppLayout :title="'Edit ' + owner.first_name + ' ' + owner.last_name + ' CV'">
        <AddEditLayout @change-to="switchCategory" :child-category="category">
            <div v-if="form.isDirty" class="flex fixed p-5 top-20 justify-center w-full space-x-3">
                <div class="flex items-center text-sm">You have unsaved changes.</div>
                <form @submit.prevent="updateCV">
                    <DangerButton type="submit" :disabled="form.processing" >Save Changes</DangerButton>
                </form>
            </div>
            <div class="flex justify-center items-center h-screen flex-col space-y-5">
                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'contact'">
                    <h2 class="font-bold text-xl text-center pb-8">Contact Data</h2>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <Label for="first_name" :value="'First Name'"/>
                            <Input type="text" id="first_name" placeholder="Jānis" required v-model="form.firstName"/>
                        </div>
                        <div>
                            <Label for="last_name" :value="'Last name'"/>
                            <Input type="text" id="last_name" placeholder="Bērziņš" required v-model="form.lastName"/>
                        </div>
                        <div>
                            <Label for="phone" :value="'Phone Number'"/>
                            <Input type="tel" id="phone" placeholder="20000000" required v-model="form.phoneNumber"/>
                        </div>
                        <div>
                            <Label for="profession" :value="'Profession'"/>
                            <Input type="text" id="profession" placeholder="PHP Developer" required v-model="form.profession"/>
                        </div>
                        <div>
                            <Label for="city" :value="'City'"/>
                            <Input type="text" id="city" placeholder="Rīga" required v-model="form.city"/>
                        </div>
                        <div>
                            <Label for="country" :value="'Country'"/>
                            <Input type="text" id="country" placeholder="Latvia" required v-model="form.country"/>
                        </div>
                    </div>

                    <div>
                        <Label for="email" :value="'Email'"/>
                        <Input type="email" id="email" placeholder="janis@berzins.com" required v-model="form.email"/>
                    </div>

                    <div class="flex flex-col mb-6 mt-4">
                        <Label for="description" :value="'Profile Description'"/>
                        <TextArea
                            id="description"
                            rows="5"
                            placeholder="Type your description here"
                            v-model="form.ownerDescription"
                        />
                    </div>

                    <div class="flex justify-between">
                        <PageLink :href="route('show')">Back</PageLink>
                        <Button @click="switchCategory('employmentHistorySummary')">Next: Employment History</Button>
                    </div>
                </div>

                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'employmentHistorySummary'">
                    <div class="flex flex-row justify-between pb-8 flex items-center">
                        <h2 class="font-bold text-xl text-center">Employment History Summary</h2>
                        <Button @click="switchCategory('employmentHistory')">Add Position</Button>
                    </div>
                    <div v-if="form.employmentHistoryList.length > 0" class="flex flex-col h-96 space-y-3 mb-5 overflow-y-auto">
                        <div v-for="(job, index) in form.employmentHistoryList" :key="index" class="p-5 bg-gray-50 border rounded shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span>{{ job.job_title }} at {{ job.employer }}</span>
                                    <span>From {{ date(job.start) }} to {{ date(job.end) }}</span>
                                </div>
                                <div>
                                    <EditButton @click="editPosition(index)"/>
                                    <DeleteButton @click="removeItem(index, form.employmentHistoryList)"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="flex justify-center items-center h-96 mb-5">Fill out you work history...</div>

                    <div class="flex justify-between">
                        <SecondaryButton @click="switchCategory('contact')">Back</SecondaryButton>
                        <Button @click="switchCategory('educationSummary')">Next: Education</Button>
                    </div>
                </div>

                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'employmentHistory'">
                    <h2 class="font-bold text-xl text-center pb-8">Work History</h2>
                    <div class="flex flex-col h-96 mb-6">
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <Label for="job_title" :value="'Job Title'"/>
                                <Input type="text" id="job_title" placeholder="PHP Developer" required v-model="jobTitle"/>
                            </div>
                            <div>
                                <Label for="employer" :value="'Employer'"/>
                                <Input type="text" id="employer" placeholder="Facebook" required v-model="employer"/>
                            </div>
                            <div>
                                <Label for="start" :value="'Start Date'"/>
                                <Input type="date" id="start" required v-model="startedJob"/>
                            </div>
                            <div>
                                <Label for="end" :value="'End Date'"/>
                                <Input type="date" id="end" required v-model="endedJob"/>
                            </div>
                        </div>

                        <div class="flex flex-col mb-6">
                            <Label for="workDescription" :value="'Work Description and Achievements'"/>
                            <TextArea
                                id="workDescription"
                                rows="5"
                                placeholder="Type your achievements and responsibilities here..."
                                v-model="descriptionAndAchievements"
                            />
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <SecondaryButton @click="switchCategory('employmentHistorySummary'); resetPositionForm()">
                            Back
                        </SecondaryButton>
                        <div class="flex items-end space-x-3">
                            <span v-if="jobTitle === null || employer === null || startedJob === null || endedJob === null || descriptionAndAchievements === null" class="flex text-xs">
                                Fill all input fields.
                            </span>
                            <Button
                                :disabled="jobTitle === null || employer === null || startedJob === null || endedJob === null || descriptionAndAchievements === null"
                                @click="switchCategory('employmentHistorySummary'); editPositionIndex !== null ? saveEditedPosition(editPositionIndex) : addToEmploymentList()">
                                <span v-if="editPositionIndex !== null">Save</span>
                                <span v-else>Add</span>
                            </Button>
                        </div>
                    </div>
                </div>

                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'educationSummary'">
                    <div class="flex flex-row justify-between mb-8 flex items-center">
                        <h2 class="font-bold text-xl text-center">Education Summary</h2>
                        <Button @click="switchCategory('education')">Add Institution</Button>
                    </div>
                    <div v-if="form.educationSummaryList.length > 0" class="flex flex-col h-96 space-y-3 mb-5 overflow-y-auto">
                        <div v-for="(institution, index) in form.educationSummaryList" :key="index" class="p-5 bg-gray-50 border rounded shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span>{{ institution.institution }}</span>
                                    <span v-if="institution.currently_attending">From {{ date(institution.started_at) }} - Current</span>
                                    <span v-else>From {{ date(institution.started_at) }} to {{ date(institution.ended_at) }}</span>
                                </div>
                                <div>
                                    <EditButton @click="editEducationInstitution(index)"/>
                                    <DeleteButton @click="removeItem(index, form.educationSummaryList)"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="flex justify-center items-center h-96 mb-5">Add Education Institution...</div>

                    <div class="flex justify-between">
                        <SecondaryButton @click="switchCategory('employmentHistorySummary')">Back</SecondaryButton>
                        <Button @click="switchCategory('skills')">Next: Skills</Button>
                    </div>
                </div>

                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'education'">
                    <h2 class="font-bold text-xl text-center pb-8">Education</h2>
                    <div class="flex flex-col h-96 mb-6">
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <Label for="education_institution" :value="'Education Institution'"/>
                                <Input type="text" id="education_institution" placeholder="Rīgas Tehniskā Universitāte" required v-model="educationInstitution"/>
                            </div>
                            <div>
                                <Label for="field_of_study" :value="'Field Of Study'"/>
                                <Input type="text" id="field_of_study" placeholder="Business Administration" required v-model="fieldOfStudy"/>
                            </div>
                            <div>
                                <Label for="degree" :value="'Degree'"/>
                                <Input type="text" id="degree" placeholder="Ph.D" required v-model="degree"/>
                            </div>
                        </div>

                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <Label for="started_at" :value="'Graduation Start Date'"/>
                                <Input type="date" id="started_at" required v-model="startedAt"/>
                            </div>
                            <div>
                                <Label for="ended_at" :value="'Graduation End Date'"/>
                                <Input type="date" id="ended_at" :disabled="currentlyAttending" class="disabled:bg-gray-200" required v-model="endedAt"/>
                            </div>
                        </div>

                        <div class="flex items-start mb-6">
                            <div class="flex items-center h-5">
                                <Checkbox id="currently_attend" v-model:checked="currentlyAttending"/>
                            </div>
                            <label for="currently_attend" class="ml-2 text-sm font-medium text-gray-900">
                                I currently attend here
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <SecondaryButton @click="switchCategory('educationSummary'); resetEducationForm()">
                            Back
                        </SecondaryButton>
                        <div class="flex space-x-3 items-end">
                            <span v-if="educationInstitution === null || fieldOfStudy === null || degree === null || startedAt === null || (currentlyAttending === false && endedAt === null)" class="flex text-xs">
                                Fill all input fields.
                            </span>
                            <Button
                                :disabled="educationInstitution === null || fieldOfStudy === null || degree === null || startedAt === null || (currentlyAttending === false && endedAt === null)"
                                @click="switchCategory('educationSummary'); editEducationIndex !== null ? saveEditedEducationInstitution(editEducationIndex) :  addToEducationSummaryList()">
                                <span v-if="editEducationIndex !== null">Save</span>
                                <span v-else>Add</span>
                            </Button>
                        </div>
                    </div>
                </div>

                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'skills'">
                    <div class="flex justify-between mb-8 flex items-center">
                        <h2 class="font-bold text-xl text-center">Skills</h2>
                        <Button type="button" class="w-fit" :disabled="form.skills[form.skills.length - 1] === ''" @click="addSkill">Add Skill</Button>
                    </div>
                    <div v-if="form.skills.length > 0" class="flex flex-col space-y-2 h-96 mb-5 overflow-y-auto">
                        <div class="flex flex-row items-center" v-for="(skill, index) in form.skills" :key="index">
                            <Input type="text" :id="'skill_' + index" v-model="form.skills[index].skill"/>
                            <DeleteButton class="mx-3" @click="removeItem(index, form.skills)"/>
                        </div>
                    </div>
                    <div  v-else class="h-96 flex justify-center items-center mb-5">Add skills...</div>

                    <div class="flex justify-between">
                        <SecondaryButton @click="switchCategory('educationSummary')">Back</SecondaryButton>
                        <Button @click="switchCategory('languages')">Next: Languages</Button>
                    </div>
                </div>

                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'languages'">
                    <div class="flex justify-between mb-8 flex items-center">
                        <h2 class="font-bold text-xl text-center">Languages</h2>
                        <Button type="button" class="w-fit" :disabled="form.languages[form.languages.length - 1] === ''" @click="addLanguage">Add Language</Button>
                    </div>
                    <div v-if="form.languages.length > 0" class="flex flex-col space-y-2 h-96 mb-5 overflow-y-auto">
                        <div class="flex flex-row items-center" v-for="(skill, index) in form.languages" :key="index">
                            <Input type="text" :id="'language_' + index" v-model="form.languages[index].language"/>
                            <DeleteButton class="mx-3" @click="removeItem(index, form.languages)"/>
                        </div>
                    </div>
                    <div  v-else class="h-96 flex justify-center items-center mb-5">Add languages...</div>

                    <div class="flex justify-between">
                        <SecondaryButton @click="switchCategory('skills')">Back</SecondaryButton>
                        <Button @click="switchCategory('social')">Next: Social</Button>
                    </div>
                </div>

                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'social'">
                    <div class="flex justify-between mb-8 flex items-center">
                        <h2 class="font-bold text-xl text-center">Social Links</h2>
                        <div class="flex space-x-2">
                            <Button :disabled="findSocialType('linkedin') !== undefined" type="button" class="w-fit" @click="addSocial('linkedin')">Add Linkedin</Button>
                            <Button :disabled="findSocialType('github') !== undefined" type="button" class="w-fit" @click="addSocial('github')">Add GitHub</Button>
                            <Button :disabled="findSocialType('website') !== undefined" type="button" class="w-fit" @click="addSocial('website')">Add Website</Button>
                        </div>
                    </div>
                    <div v-if="form.socials.length > 0" class="flex flex-col space-y-2 h-96 mb-5 overflow-y-auto">
                        <div class="flex flex-row items-center" v-for="(socialLink, index) in form.socials" :key="index">
                            <div class="pl-1 flex w-full space-x-3 items-center">
                                <font-awesome-icon v-if="socialLink.type === 'linkedin'" icon="fa-brands fa-linkedin" class="h-5 w-5"/>
                                <font-awesome-icon v-if="socialLink.type === 'github'" icon="fa-brands fa-github" class="h-5 w-5"/>
                                <font-awesome-icon v-if="socialLink.type === 'website'" icon="fa-solid fa-globe" class="h-5 w-5"/>
                                <Input type="text" :id="socialLink.type" v-model="form.socials[index].link"/>
                            </div>
                            <DeleteButton class="mx-3" @click="removeItem(index, form.socials)"/>
                        </div>
                    </div>
                    <div  v-else class="h-96 flex justify-center items-center mb-5">Add social links...</div>

                    <div class="flex justify-between">
                        <SecondaryButton @click="switchCategory('languages')">Back</SecondaryButton>
                    </div>
                </div>
            </div>
        </AddEditLayout>
    </AppLayout>
</template>


<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import AddEditLayout from '../Layouts/AddEditLayout.vue'
import Button from '../Components/Button.vue'
import SecondaryButton from "../Components/SecondaryButton.vue";
import DangerButton from '../Components/DangerButton.vue'
import PageLink from '../Components/PageLink.vue'
import Label from '../Components/Label.vue'
import DeleteButton from '../Components/DeleteButton.vue'
import EditButton from '../Components/EditButton.vue'
import Checkbox from '../Components/Checkbox.vue'
import Input from '../Components/Input.vue'
import TextArea from "../Components/TextArea.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {nextTick, onBeforeUpdate, onMounted, onUpdated, ref} from "vue";
import Swal from 'sweetalert2'

let category = ref('contact')
let editPositionIndex = ref(null)
let editEducationIndex = ref(null)

let jobTitle = ref(null)
let employer = ref(null)
let descriptionAndAchievements = ref(null)
let startedJob = ref(null)
let endedJob = ref(null)

let educationInstitution = ref(null)
let fieldOfStudy = ref(null)
let degree = ref(null)
let currentlyAttending = ref(null)
let startedAt = ref(null)
let endedAt = ref(null)

const props = defineProps({
    owner: Object,
    workHistory: Array,
    educationInstitutions: Array,
    skills: Array,
    languages: Array,
    socials: Array
})

const form = useForm({
    firstName: props.owner.first_name,
    lastName: props.owner.last_name,
    phoneNumber: props.owner.phone_number,
    profession: props.owner.profession,
    email: props.owner.email,
    city: props.owner.city,
    country: props.owner.country,
    ownerDescription: props.owner.description,

    employmentHistoryList: props.workHistory,
    educationSummaryList: props.educationInstitutions,
    skills: props.skills,
    languages: props.languages,
    socials: props.socials
});

const updateCV = () => {
    form.put(route('update.cv', props.owner.id), {
        preserveScroll: true,
        onSuccess: () => {
            successAlert()
        },
    });
};

const switchCategory = (inputCategory) => {
    category.value = inputCategory
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

const successAlert = () => {
    Toast.fire({
        icon: 'success',
        title: 'Changes Saved Successfully!'
    })
}

async function addLanguage() {
    form.languages.push({ 'language' : '' })
    await nextTick()
    document.getElementById(`language_${form.languages.length - 1}`).focus()
}

async function addSkill() {
    form.skills.push({ 'skill' : '' })
    await nextTick()
    document.getElementById(`skill_${form.skills.length - 1}`).focus()
}

async function addSocial(type) {
    form.socials.push({'type': type, 'link': ''})
    await nextTick()
    document.getElementById(type).focus()
}

const findSocialType = (type) => {
    return form.socials.find(e => e.type === type)
}

const removeItem = (index, array) => {
    array.splice(index, 1)
}

const editPosition = (index) => {
    editPositionIndex.value = index
    category.value = 'employmentHistory'
    jobTitle.value = form.employmentHistoryList[index].job_title
    employer.value = form.employmentHistoryList[index].employer
    descriptionAndAchievements.value = form.employmentHistoryList[index].description
    startedJob.value = form.employmentHistoryList[index].start
    endedJob.value = form.employmentHistoryList[index].end
}

const saveEditedPosition = (index) => {
    form.employmentHistoryList[index] = {
        'job_title': jobTitle.value,
        'employer': employer.value,
        'description': descriptionAndAchievements.value,
        'start': startedJob.value,
        'end': endedJob.value
    }
    resetPositionForm()
}

const resetPositionForm = () => {
    jobTitle.value = null
    employer.value = null
    descriptionAndAchievements.value = null
    startedJob.value = null
    endedJob.value = null
    resetPositionIndex()
}

const resetPositionIndex = () => {
    editPositionIndex.value = null
}

const resetEducationIndex = () => {
    editEducationIndex.value = null
}

const resetIndex = (index) => {
    index = null
}

const addToEmploymentList = () => {
    form.employmentHistoryList.push({
        'job_title': jobTitle.value,
        'employer': employer.value,
        'description': descriptionAndAchievements.value,
        'start': startedJob.value,
        'end': endedJob.value
    })
    resetPositionForm()
}

const addToEducationSummaryList = () => {
    form.educationSummaryList.push({
        'institution': educationInstitution.value,
        'field_of_study': fieldOfStudy.value,
        'degree': degree.value,
        'currently_attending': currentlyAttending.value,
        'started_at': startedAt.value,
        'ended_at': endedAt.value
    })
    resetEducationForm()
}

const resetEducationForm = () => {
    educationInstitution.value = null
    fieldOfStudy.value = null
    degree.value = null
    currentlyAttending.value = null
    startedAt.value = null
    endedAt.value = null
    resetEducationIndex()
}

const editEducationInstitution = (index) => {
    editEducationIndex.value = index
    category.value = 'education'
    educationInstitution.value = form.educationSummaryList[index].institution
    fieldOfStudy.value = form.educationSummaryList[index].field_of_study
    degree.value = form.educationSummaryList[index].degree
    currentlyAttending.value = Boolean(form.educationSummaryList[index].currently_attending)
    startedAt.value = form.educationSummaryList[index].started_at
    endedAt.value = form.educationSummaryList[index].ended_at
}

const saveEditedEducationInstitution = (index) => {
    form.educationSummaryList[index] = {
        'institution': educationInstitution.value,
        'field_of_study': fieldOfStudy.value,
        'degree': degree.value,
        'currently_attending': currentlyAttending.value,
        'started_at': startedAt.value,
        'ended_at': endedAt.value
    }
    resetEducationForm()
}

const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

const date = (date) => {
    let dt = new Date(date);
    return monthNames[dt.getMonth()] + ' ' + dt.getFullYear()
}


</script>
