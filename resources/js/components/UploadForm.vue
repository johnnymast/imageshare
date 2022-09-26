<template>
    <div v-show="error" class="error" ref="error" v-text="error_message"></div>
    <form method="POST" enctype="application/x-www-form-urlencoded" :action="url">


        <div class="p-5 my-5 border-dashed border-2 border-sky-500 text-center dz-clickable" ref="uploader">
            Drag and drop a file here<br/>or press
            <button
                class="dz-clickable w-full my-5 flex justify-center bg-purple-800  hover:bg-purple-700 text-gray-100 p-3  rounded-lg tracking-wide font-semibold  cursor-pointer transition ease-in duration-500 disabled:bg-gray-300"
                type="button"
            >UPLOAD
            </button>
        </div>


        <span class="text-black font-bold my-3 block">
            Expires in
        </span>
        <div class="relative inline-flex self-center mb-5">
            <svg class="text-white bg-purple-700 absolute top-0 right-0 m-2 pointer-events-none p-2 rounded"
                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px"
                 height="40px" viewBox="0 0 38 22" version="1.1">
                <title>F09B337F-81F6-41AC-8924-EC55BA135736</title>
                <g id="ZahnhelferDE—Design" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="ZahnhelferDE–Icon&amp;Asset-Download" transform="translate(-539.000000, -199.000000)"
                       fill="#ffffff" fill-rule="nonzero">
                        <g id="Icon-/-ArrowRight-Copy-2" transform="translate(538.000000, 183.521208)">
                            <polygon id="Path-Copy"
                                     transform="translate(20.000000, 18.384776) rotate(135.000000) translate(-20.000000, -18.384776) "
                                     points="33 5.38477631 33 31.3847763 29 31.3847763 28.999 9.38379168 7 9.38477631 7 5.38477631"/>
                        </g>
                    </g>
                </g>
            </svg>
            <select name="expires_at"
                    class=" font-bold rounded border-2 border-purple-700 text-gray-600 h-14 w-72 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none">
                <option value="1day">1 Day</option>
                <option value="1week">1 Week</option>
                <option value="1month">1 Month</option>
                <option value="1view">1 View</option>
                <option value="2view">2 Views</option>
                <option value="never">Never expire</option>
            </select>
        </div>

        <input name="_method" type="hidden" value="PATCH">
        <input type="hidden" name="_token" :value="token">
        <input
            class="w-full flex justify-center bg-purple-800  hover:bg-purple-700 text-gray-100 p-3  rounded-lg tracking-wide font-semibold  cursor-pointer transition ease-in duration-500 disabled:bg-gray-300"
            type="submit"
            ref="submit"
            value="Save"
            disabled
        />
    </form>
</template>

<script>
import { Dropzone } from 'dropzone'

// disable multi upload
export default {
    name: 'UploadForm',
    data () {
        return {
            'token': '',
            'error': true,
            'error_message': '',
            'url': '',
        }
    },
    created () {
        const crfToken = document.querySelector('meta[name="token"]')
        this.token = crfToken.content
    },
    mounted () {

        const dropzone = new Dropzone(this.$refs.uploader, {
            url: 'upload', headers: {
                'X-CSRF-TOKEN': this.token
            },
            clickable: '.dz-clickable',
            maxFiles: 1,
            previewTemplate: this.previewTemplate(),
            init: function()  {
              this.on("addedfile", () =>  {
                  const oldFile = document.querySelectorAll('.file-row');

                  if (typeof oldFile !== 'undefined' && oldFile.length > 1) {
                      oldFile[0].remove();
                  }

              })
            },
            success: (file, response) => {
                this.url = 'upload/' + response.hash
                this.$refs.submit.removeAttribute('disabled')
            },
            error: (file, response) => {
                this.error_message = response.message
                this.error = true
            }

        })
    },
    methods: {

        previewTemplate () {
            return ' <div class="file-row">\n' +
                '    <div>\n' +
                '        <span class="preview"><img class="auto m-auto" data-dz-thumbnail /></span>\n' +
                '    </div>\n' +
                '    <div>\n' +
                '        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">\n' +
                '          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '  </div>\n'
        }
    }
}
</script>

<style scoped>
.error {
    color: red;
    font-weight: bold;
}
</style>
