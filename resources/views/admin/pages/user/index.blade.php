$("#alert_demo_8").click(function (e) {
            swal({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              type: "warning",
              buttons: {
                cancel: {
                  visible: true,
                  text: "No, cancel!",
                  className: "btn btn-danger",
                },
                confirm: {
                  text: "Yes, delete it!",
                  className: "btn btn-success",
                },
              },
            }).then((willDelete) => {
              if (willDelete) {
                swal("Poof! Your imaginary file has been deleted!", {
                  icon: "success",
                  buttons: {
                    confirm: {
                      className: "btn btn-success",
                    },
                  },
                });
              } else {
                swal("Your imaginary file is safe!", {
                  buttons: {
                    confirm: {
                      className: "btn btn-success",
                    },
                  },
                });
              }
            });
          });