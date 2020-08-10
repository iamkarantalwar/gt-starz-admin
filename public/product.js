var selectedVariants = [];
$(document).ready(function() {
    //Last Three Are Reserved For The
    const lastTr = `
    <td>
        <input required name='price[]' class='form-control' type='number' placeholder='Enter Price'>
    </td>
    <td>
        <input required name='discount[]' class='form-control' type='number' placeholder='Enter Discount'>
    </td>
    <td class="">
        <div class="card" style="width: 11rem;">
            <img class="card-img-top" src="../../no-image.jpg" alt="Card image cap">
            <div class="card-body">
                <input type="file" name="image[]" onchange="selectImage(this);" required class="select-variant-image-file" style="display:none;">
                <a href="javascript:void(0);" onclick="openDialogBox();" class="btn btn-primary select-variant-image">Select Image</a>
            </div>
        </div>
    </td>
    <td>
    <i class="ni ni-fat-remove remove-variation-row" onclick="removeRow(this)" title="Remove Whole Row"></i>
    </td>
    `;
    $('#add-variation-btn').unbind("click").click(function() {
        const variationOption = $('#add-variation-select').val();
        const variationOptionText = $('#add-variation-select option:selected').text();
        if(variationOption === "")
        {
            swal('Please select the variation type');
        }
        else
        {
            // Add Variation Option on the top of the table Head
            const th = `<th scope="col">${variationOptionText} <i class="ni ni-fat-remove remove-variation" id="variant-${variationOption}" title="Delete This Variation"></i></th>`;
            $('#product-variation-thead').prepend(th);
            //Apend into the Variants
            selectedVariants.splice(0, 0, {
                variant: variationOptionText,
                value: variationOption
            });
            // Delete Variation Option From There
            $('#add-variation-select option:selected').remove();
            //Add the tr

            //Calculate the table rows
            let columns = $('#product-variation-thead').children('th').length;

            //Check if any row is inserted before or not
            const productVariationTbodyTrCount = $('#product-variation-tbody').children('tr').length;
            //Show the add more button
            $('#add-more').css('display', 'block');

            const beforeLastTr = `<td>
                                        <input
                                            required
                                            type=${variationOption === "COLOUR" || variationOption === "COLOR" ? 'color' : 'text'}
                                            name='variant-${variationOption}[]'
                                            class='form-control'>
                                  </td>`;

            var tbodyTrs = $('#product-variation-tbody').children('tr');
            if(productVariationTbodyTrCount > 0)
            {
               $(tbodyTrs).each(function(){
                    $(this).prepend(beforeLastTr);
               });
            } else {
                const tr = `<tr>${beforeLastTr}${lastTr}</tr>`;
                $('#product-variation-tbody').append(tr);
            }

            $(tbodyTrs).each(function(){
                var index = 0;
                $(this).children('td').each(function(){
                    if(index < selectedVariants.length)
                    {
                        $(this).find('input').attr('name', `variant-${selectedVariants[index].value}[]`);
                    }
                    index = index +1;
                });
            });
        }

        //Image Select
        $(document).unbind("click").on('click', '.select-variant-image', function(){
            var closestImageBox = $(this).closest('div').find('.select-variant-image-file');
            $(closestImageBox).trigger('click');
        });

        //Change Of image show in box
        $('.select-variant-image-file').change(function(e){

            let input = this;
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var closestImageBox = $(input).closest('td').find('.card-img-top');
                    $(closestImageBox).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }else{
                swal('Check Your Image Format.');
            }
        });

        //Click Of Add More Button
        $('#add-more').unbind("click").click(function () {
            var tr ='<tr>';
            selectedVariants.forEach((variant) => tr += `<td><input required type='text' class='form-control' name='variant-${variant.value}[]'></td>`);
            tr = tr+lastTr + "</tr>";
            $('#product-variation-tbody').append(tr);
        });

        //Click of remove button
        $('.remove-variation').unbind("click").click(function() {
            //Find which option is going to delete
            var selectedOptionId = $(this).attr('id').split('-')[1];
            var selectedOption = selectedVariants.find((variant) => variant.value == selectedOptionId);
            //Add That Inside the Seleect box
            $('#add-variation-select').append(`<option value='${selectedOption.value}'>${selectedOption.variant}</option>`)

            //Check count of the the table head
            var count = $('#product-variation-thead').children('th').length;
            if(count === 5){
                //Remove from the head
                $(this).closest('th').remove();
                // Empty all the table
                $('#product-variation-tbody').html('');
                //Hide add more button
                $('#add-more').css('display', 'none');
                selectedVariants = selectedVariants.filter((variant) => variant.value != selectedOptionId);
            } else if(count > 5) {
                 //Remove from the head
                 $(this).closest('th').remove();
                 $('#product-variation-tbody').children('tr').each(function() {
                   var optionBoxes =  $(this).find(`input[name="variant-${selectedOption.value}[]"]`);
                   $(optionBoxes).each(function() {
                    $(this).closest('td').remove();
                   });
                 });
                 selectedVariants = selectedVariants.filter((variant) => variant.value != selectedOptionId);
            }
        });

        // Remove Whole ROw
        $('.remove-variation-row').unbind("click").click(function(){

        })
    });


});

function removeRow(e)
{
    var count = $('#product-variation-tbody').children('tr').length;
    const selectedVariantsCount = selectedVariants.length;
    if(count == 1)
    {
        $('#add-more').css('display', 'block');
        selectedVariants.forEach((selectedOption) => {
            $('#add-variation-select').append(`<option value='${selectedOption.value}'>${selectedOption.variant}</option>`)
            selectedVariants = selectedVariants.filter((variant) => variant.value != selectedOption.value);
        });
        var index = 0;
        $('#product-variation-thead').children('th').each(function() {
            if(index < selectedVariantsCount)
            {
                $(this).remove();
            }
            index = index + 1;
        });
    }
    $(e).closest('tr').remove();
}

function openDialogBox()
{
    $(this).closest('td').find('input[type="image"]').trigger('click');
}

function selectImage(e)
{
     let input = $(e);
     var url = $(e).val();
     const files = $(e)[0].files[0];
     var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
     if (files && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
         var reader = new FileReader();

         reader.onload = function (e) {
             var closestImageBox = $(input).closest('td').find('.card-img-top');
             $(closestImageBox).attr('src', e.target.result);
         }

         reader.readAsDataURL(files);
     }else{
         swal('Check Your Image Format.');
     }
}
