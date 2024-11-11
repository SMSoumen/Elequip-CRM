$(document).ready(function () {
    let basepath = ""
    $(document).on(
        "switchChange.bootstrapSwitch",
        ".statusChange",
        function (e) {
            // console.log($(this).data("model"));
            let modelName = $(this).data("model");
            let modelId = $(this).data("modelid");
            let status = e.target.checked;
            $.ajax({
                url: "/admin/common-status-change",
                method: "POST",
                data: {
                    modelName,
                    modelId,
                    status,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response.error);
                    if (!response.error) {
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                },
            });
        }
    );

    $("#add_prod_attribute").on("click", function () {
        let selected_attr = $("#prod_attr_select").find(":selected");
        let attr_id = selected_attr.val();
        let attr_name = selected_attr.text();
        // let product_id = $("#product_id").val();
        // console.log(product_id);
        selected_attr.attr("disabled", true);

        if (attr_id != "") {
            $.ajax({
                url:    basepath+ "/admin/get-attr-value",
                method: "POST",
                dataType: "json",
                data: {
                    attr_id,
                    attr_name,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    // console.log(response);
                    if (response.error == false) {
                        $(".selected_attr_box").append(response.data.viewdata);
                        $(
                            ".select2-" + response.data.rawdata.attribute_slug
                        ).select2();
                        // console.log($("#prod_attr_select option:first"));
                        $("#selected_attr_box option:first").attr(
                            "selected",
                            "true"
                        );
                        // $("#prod_attr_select").select2();
                        // console.log($("#prod_attr_select option[value='1']"));
                        // $("#prod_attr_select option[value='1']").attr('disabled', true);
                    }
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
    });

    $("#product_type").on("change", function () {
        let prod_type = $(this).val();
        if (prod_type == 1) {
            $(".variable_product_wrap").hide();
        } else if (prod_type == 2) {
            $(".variable_product_wrap").show();
        }
    });

    $("#add_prod_variant").on("click", function () {
        console.log("Test");
        let generate_var = $("#variant_add").find(":selected");

        let generate_var_type = generate_var.val();
        let attr_box = $(".selected_attr_box > .row");
        let variation_box_wrapper = $(".variation_box");
        let variation_counter = variation_box_wrapper.children().length;

        // console.log();
        // console.log(attr_count);

        if (attr_box.length > 0) {
            var attr_arr = [];
            if (generate_var_type == "add_single_variation") {
                let attr_names = [];
                let attr_values = [];
                var element = $.each(attr_box, function (index, item) {
                    var attr_class_name = item.classList[1];
                    var varchk = $(
                        `.${attr_class_name} .variation_check_${item.dataset.attr}`
                    ).prop("checked");
                    if (!varchk) {
                        return true;
                    }

                    attr_names.push(item.dataset.attr);

                    var tt = $(`.${attr_class_name} select`).children(
                        "option:selected"
                    );

                    let temp_attr_val = [];
                    var httml = $.each(tt, function (j, itm) {
                        var txtt = itm.innerText;
                        var sl_val = itm.value;
                        temp_attr_val.push([txtt, sl_val]);
                    });

                    attr_values.push(temp_attr_val);
                    temp_attr_val = null;
                });

                console.log(attr_names);
                console.log(attr_values);

                if (attr_names.length > 0 && attr_values.length > 0) {
                    $.ajax({
                        url: "/admin/get-variant-template",
                        method: "POST",
                        dataType: "json",
                        data: {
                            attr_names,
                            attr_values,
                            variation_counter,
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (response) {
                            console.log(response);
                            if (response.error == false) {
                                $(".variation_box").append(
                                    response.data.viewdata
                                );
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
                }
            } else if (generate_var_type == "generate_all_variation") {
            }
        } else {
        }
    });
});
