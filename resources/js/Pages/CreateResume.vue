<template>
    <AppLayout title="Create CV">
        <AddEditLayout @change-to="switchCategory" :child-category="category">
            <div class="flex justify-center items-center h-screen flex-col space-y-5">
                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'contact'">
                    <h2 class="font-bold text-xl text-center mb-8">General</h2>
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
                            rows="4"
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
                    <div class="flex flex-row justify-between mb-8 flex items-center">
                        <h2 class="font-bold text-xl text-center">Employment History Summary</h2>
                        <Button @click="switchCategory('employmentHistory')">Add Position</Button>
                    </div>
                    <div v-if="form.employmentHistoryList.length > 0" class="flex flex-col h-96 space-y-3 mb-5 overflow-y-auto">
                        <div v-for="(job, index) in form.employmentHistoryList" :key="index" class="p-5 bg-gray-50 border rounded shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span>{{ job.jobTitle }} at {{ job.employer }}</span>
                                    <span>From {{ date(job.startedJob) }} to {{ date(job.endedJob) }}</span>
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
                    <h2 class="font-bold text-xl text-center mb-8">Work History</h2>
                    <div class="flex flex-col h-96 mb-6">
                        <div>
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <Label for="job_title" :value="'Job Title'"/>
                                    <Input type="text" id="job_title" placeholder="PHP Developer" required
                                           v-model="jobTitle"/>
                                </div>
                                <div>
                                    <Label for="employer" :value="'Employer'"/>
                                    <Input type="text" id="employer" placeholder="Facebook" required
                                           v-model="employer"/>
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
                                    rows="4"
                                    placeholder="Type your achievements and responsibilities here..."
                                    v-model="descriptionAndAchievements"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <SecondaryButton @click="switchCategory('employmentHistorySummary'); resetPositionForm()">
                            Back
                        </SecondaryButton>
                        <Button @click="switchCategory('employmentHistorySummary'); editPositionIndex !== null ? saveEditedPosition(editPositionIndex) : addToEmploymentList()">
                            <span v-if="editPositionIndex !== null">Save</span>
                            <span v-else>Add</span>
                        </Button>
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
                                    <span>{{ institution.educationInstitution }}</span>
                                    <span v-if="institution.currentlyAttending">From {{ date(institution.startedAt) }} - Current</span>
                                    <span v-else>From {{ date(institution.startedAt) }} to {{ date(institution.endedAt) }}</span>
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
                    <h2 class="font-bold text-xl text-center mb-8">Education</h2>
                    <div class="flex flex-col h-96 mb-6">
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <Label for="education_institution" :value="'Education Institution'"/>
                                <Input type="text" id="education_institution" placeholder="Rīgas Tehniskā Universitāte"
                                       required v-model="educationInstitution"/>
                            </div>
                            <div>
                                <Label for="field_of_study" :value="'Field Of Study'"/>
                                <Input type="text" id="field_of_study" placeholder="Business Administration" required
                                       v-model="fieldOfStudy"/>
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
                        <Button @click="switchCategory('educationSummary'); editEducationIndex !== null ? saveEditedEducationInstitution(editEducationIndex) :  addToEducationSummaryList()">
                            <span v-if="editEducationIndex !== null">Save</span>
                            <span v-else>Add</span>
                        </Button>
                    </div>
                </div>

                <div class="lg:w-[35rem] border shadow p-7 rounded" v-if="category === 'skills'">
                    <div class="flex justify-between mb-8 flex items-center">
                        <h2 class="font-bold text-xl text-center">Skills</h2>
                        <Button type="button" class="w-fit" :disabled="form.skills[form.skills.length - 1] === ''" @click="addSkill">Add Skill</Button>
                    </div>
                    <div v-if="form.skills.length > 0" class="flex flex-col space-y-2 h-96 mb-5 overflow-y-auto">
                        <div class="flex flex-row items-center" v-for="(skill, index) in form.skills" :key="index">
                            <Input type="text" :id="'skill_' + index" v-model="form.skills[index]"/>
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
                            <Input type="text" :id="'language_' + index" v-model="form.languages[index]"/>
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
                    <form @submit.prevent="addCV">
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
                            <DangerButton :disabled="form.processing">Create CV</DangerButton>
                        </div>
                    </form>
                </div>
            </div>
        </AddEditLayout>
    </AppLayout>
</template>

<script setup>
import Button from '../Components/Button.vue'
import DangerButton from '../Components/DangerButton.vue'
import SecondaryButton from "../Components/SecondaryButton.vue";
import PageLink from '../Components/PageLink.vue'
import Label from '../Components/Label.vue'
import Checkbox from '../Components/Checkbox.vue'
import DeleteButton from '../Components/DeleteButton.vue'
import EditButton from '../Components/EditButton.vue'
import Input from '../Components/Input.vue'
import TextArea from "../Components/TextArea.vue";
import AppLayout from '../Layouts/AppLayout.vue'
import AddEditLayout from '../Layouts/AddEditLayout.vue'
import {useForm} from "@inertiajs/inertia-vue3";
import {nextTick, ref} from "vue";
import Swal from "sweetalert2";
import {Inertia} from "@inertiajs/inertia";


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

const form = useForm({
    firstName: '',
    lastName: '',
    profession: '',
    phoneNumber: '',
    email: '',
    city: '',
    country: '',
    ownerDescription: '',

    employmentHistoryList: [],
    educationSummaryList: [],
    skills: [],
    languages: [],
    socials: []
});

const addCV = () => {
    form.post(route('add.create'), {
        preserveScroll: true,
        onSuccess: () => {
            Inertia.get('/')
            successAlert()
            form.reset();
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
    timer: 3500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

const successAlert = () => {
    Toast.fire({
        icon: 'success',
        title: 'CV Added Successfully!'
    })
}

async function addLanguage() {
    form.languages.push('')
    await nextTick()
    document.getElementById(`language_${form.languages.length - 1}`).focus()
}

async function addSkill() {
    form.skills.push('')
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
    jobTitle.value = form.employmentHistoryList[index].jobTitle
    employer.value = form.employmentHistoryList[index].employer
    descriptionAndAchievements.value = form.employmentHistoryList[index].descriptionAndAchievements
    startedJob.value = form.employmentHistoryList[index].startedJob
    endedJob.value = form.employmentHistoryList[index].endedJob
}

const saveEditedPosition = (index) => {
    form.employmentHistoryList[index] = {
        'jobTitle': jobTitle.value,
        'employer': employer.value,
        'descriptionAndAchievements': descriptionAndAchievements.value,
        'startedJob': startedJob.value,
        'endedJob': endedJob.value
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
        'jobTitle': jobTitle.value,
        'employer': employer.value,
        'descriptionAndAchievements': descriptionAndAchievements.value,
        'startedJob': startedJob.value,
        'endedJob': endedJob.value
    })
    resetPositionForm()
}

const addToEducationSummaryList = () => {
    form.educationSummaryList.push({
        'educationInstitution': educationInstitution.value,
        'fieldOfStudy': fieldOfStudy.value,
        'degree': degree.value,
        'currentlyAttending': currentlyAttending.value,
        'startedAt': startedAt.value,
        'endedAt': endedAt.value
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
    educationInstitution.value = form.educationSummaryList[index].educationInstitution
    fieldOfStudy.value = form.educationSummaryList[index].fieldOfStudy
    degree.value = form.educationSummaryList[index].degree
    currentlyAttending.value = form.educationSummaryList[index].currentlyAttending
    startedAt.value = form.educationSummaryList[index].startedAt
    endedAt.value = form.educationSummaryList[index].endedAt
}

const saveEditedEducationInstitution = (index) => {
    form.educationSummaryList[index] = {
        'educationInstitution': educationInstitution.value,
        'fieldOfStudy': fieldOfStudy.value,
        'degree': degree.value,
        'currentlyAttending': currentlyAttending.value,
        'startedAt': startedAt.value,
        'endedAt': endedAt.value
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
