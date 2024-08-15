import { ref } from 'vue'
import { useTaskState } from 'Use/task'
import { axios } from 'spack'
import { useOnComment } from 'Use/project/onComment'

const isForm = ref<boolean>(false)
const text = ref<string>('')
const isSubmitting = ref<boolean>(false)
const files = ref<any>([])
const progress = ref<any>({})
const filePaths = ref<any>({})

export const useCommentForm = () => {
  const { comments, task, attachments } = useTaskState()

  function show() {
    console.log('hit show')
    isForm.value = true
  }

  function hide() {
    isForm.value = false
  }

  function cancel() {
    text.value = ''
    isSubmitting.value = false
    hide()
  }

  function create() {
    if (!text.value) return

    isSubmitting.value = true

    axios
      .post('/tasks/' + task.value.id + '/comments', {
        project_id: task.value.project_id,
        text: text.value,
        attachments: filePaths.value,
      })
      .then(({ data }) => {
        console.log('data')
        console.log(data)
        console.log(data.model)
        comments.value.push(data.model)
        attachments.value.push(...data.model.attachments)
        cancel()

        if (window.location.href.includes('/tasks')) return

        useOnComment().add()
      })
  }

  function onFileInput(e: any) {
    console.log('hit onFileInput')
    e.preventDefault()
    files.value = [...e.target.files]

    console.log(files.value)

    for (let i = 0; i < files.value.length; i++) {
      handleFile(i)
    }
  }

  function handleFile(index: number) {
    const file = files.value[index],
      reader = new FileReader()

    reader.readAsDataURL(file)
    reader.onload = () => {
      const formData = new FormData()
      formData.append('file', file)

      axios
        .post('file', formData, {
          onUploadProgress: function (progressEvent: any) {
            console.log('progressEvent')
            console.log(progressEvent)
            console.log(Math.round((progressEvent.loaded * 100) / progressEvent.total))
            progress.value[index] = {
              progress: Math.round((progressEvent.loaded * 100) / progressEvent.total) - 5,
              failed: false,
              success: false,
            }
          },
        })
        .then(({ data }) => {
          console.log('data')
          console.log(data)
          filePaths.value[index] = { path: data, name: file.name }
          progress.value[index] = { progress: 100, failed: false, success: true }
        })
        .catch((error) => {
          console.log(error)
          progress.value[index] = { progress: 95, failed: true, success: false }
        })
    }
  }

  function removeFile(index: number) {
    console.log(filePaths.value)
    console.log(index)
    delete filePaths.value[index]
    console.log(files.value)
    files.value.splice(index, 1)
  }

  function reset() {
    text.value = ''
    isSubmitting.value = false
    files.value = []
    progress.value = {}
    filePaths.value = {}
  }

  return {
    removeFile,
    onFileInput,
    create,
    show,
    hide,
    isForm,
    cancel,
    text,
    isSubmitting,
    files,
    progress,
    filePaths,
    reset,
  }
}
